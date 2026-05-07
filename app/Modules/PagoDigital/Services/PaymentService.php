<?php

namespace App\Modules\PagoDigital\Services;

use App\Models\MER\Pago;
use App\Models\MER\Reserva;
use App\Models\MER\Vehiculo;
use App\Modules\PagoDigital\Services\Gateways\MercadoPagoGatewayService;
use App\Modules\PagoDigital\Services\Gateways\PaymentGatewayInterface;
use App\Modules\PagoDigital\Services\Gateways\SimulatedGatewayService;
use App\Modules\PagoDigital\Services\Gateways\WompiGatewayService;
use App\Services\Reservas\ReservaDocumentoService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use InvalidArgumentException;

class PaymentService
{
    public function __construct(
        protected SimulatedGatewayService $simulatedGateway,
        protected MercadoPagoGatewayService $mercadoPagoGateway,
        protected WompiGatewayService $wompiGateway,
        protected ReservaDocumentoService $reservaDocumentoService
    ) {}

    public function process(array $data, int $userId): array
    {
        return DB::transaction(function () use ($data, $userId) {

            $vehiculo = Vehiculo::lockForUpdate()->findOrFail($data['codveh']);

            if (!(bool) $vehiculo->disp) {
                return [
                    'status' => 'rechazado',
                    'message' => 'El vehículo ya no se encuentra disponible.',
                ];
            }

            $fecini = Carbon::parse($data['pickup_date']);
            $fecfin = Carbon::parse($data['return_date']);

            $reservaActivaSolapada = Reserva::where('codveh', $vehiculo->cod)
                ->where('codestres', '!=', 3)
                ->where(function ($q) use ($fecini, $fecfin) {
                    $q->where('fecini', '<', $fecfin)
                        ->where('fecfin', '>', $fecini);
                })
                ->lockForUpdate()
                ->exists();

            if ($reservaActivaSolapada) {
                return [
                    'status' => 'rechazado',
                    'message' => 'El vehículo ya está reservado para esas fechas.',
                ];
            }

            $gateway = $this->resolveGateway($data['provider']);

            $gatewayResponse = $gateway->createPayment([
                'provider' => $data['provider'],
                'reserva_id' => $data['reserva_id'],
                'codveh' => $data['codveh'],
                'pickup_date' => $data['pickup_date'],
                'return_date' => $data['return_date'],
                'metodo_pago' => $data['metodo_pago'],
                'monto' => $data['monto'],
                'user_id' => $userId,
                'nequi_telefono' => $data['nequi_telefono'] ?? null,
                'card_numero' => $data['card_numero'] ?? null,
                'card_nombre' => $data['card_nombre'] ?? null,
                'card_expiry' => $data['card_expiry'] ?? null,
                'card_cvv' => $data['card_cvv'] ?? null,
                'transfer_comprobante' => $data['transfer_comprobante'] ?? null,
            ]);
            $gatewayResponse['status'] = $this->normalizarEstadoPago($gatewayResponse['status'] ?? 'pendiente');

            if (($gatewayResponse['status'] ?? null) === 'redirect') {
                return [
                    'status' => 'redirect',
                    'url' => $gatewayResponse['url'],
                ];
            }

            if (($gatewayResponse['status'] ?? null) === 'rechazado') {
                return [
                    'status' => 'rechazado',
                    'message' => $gatewayResponse['message'] ?? 'El pago fue rechazado.',
                ];
            }

            $reserva = Reserva::create([
                'fecrea' => now(),
                'fecini' => $fecini,
                'fecfin' => $fecfin,
                'val' => $data['monto'],
                'idusu' => $userId,
                'codveh' => $data['codveh'],
                'codestres' => 1,
            ]);

            $vehiculo->disp = 0;
            $vehiculo->save();

            $pago = Pago::create([
                'codres' => $reserva->cod,
                'idusu' => $userId,
                'referencia' => $gatewayResponse['reference'] ?? ('PAGO-' . strtoupper(Str::random(8)) . '-' . $reserva->cod),
                'metodo' => $data['metodo_pago'],
                'monto' => $data['monto'],
                'estado' => $gatewayResponse['status'],
                'moneda' => 'COP',
                'fecha_pago' => now(),
                'provider' => $data['provider'],
                'external_payment_id' => $gatewayResponse['external_payment_id'] ?? null,
                'external_reference' => $gatewayResponse['external_reference'] ?? null,
                'status_detail' => $gatewayResponse['status_detail'] ?? null,
                'detalle' => [
                    'reserva_temporal' => $data['reserva_id'],
                    'codveh' => $data['codveh'],
                    'pickup_date' => $data['pickup_date'],
                    'return_date' => $data['return_date'],
                    'gateway_response' => $gatewayResponse,
                ],
                'webhook_payload' => null,
                'approved_at' => ($gatewayResponse['status'] === 'aprobado') ? now() : null,
            ]);

            if ($gatewayResponse['status'] === 'aprobado') {
                $this->generateDocuments($reserva);
            }

            return [
                'status' => $gatewayResponse['status'],
                'reserva_id' => $reserva->cod,
                'pago_id' => $pago->id ?? null,
                'message' => $gatewayResponse['message'] ?? $this->defaultMessage($gatewayResponse['status']),
            ];
        });
    }

    protected function resolveGateway(string $provider): PaymentGatewayInterface
    {
        return match ($provider) {
            'simulated' => $this->simulatedGateway,
            'mercadopago' => $this->mercadoPagoGateway,
            'wompi' => $this->wompiGateway,
            default => throw new InvalidArgumentException("Proveedor de pago no soportado: {$provider}"),
        };
    }

    protected function generateDocuments(Reserva $reserva): void
    {
        try {
            $reserva->load([
                'user',
                'vehiculo.marca',
                'vehiculo.linea',
                'vehiculo.clase',
                'vehiculo.combustible',
                'vehiculo.ciudad',
                'vehiculo.poliza_vehiculo',
                'pago',
            ]);

            $this->reservaDocumentoService->generarYEnviar($reserva);
        } catch (\Throwable $e) {
            Log::error('Error generando documentos de reserva: ' . $e->getMessage());
        }
    }

    protected function defaultMessage(string $status): string
    {
        return match ($status) {
            'aprobado' => 'Pago aprobado correctamente.',
            'pendiente' => 'El pago quedó pendiente de validación.',
            'rechazado' => 'El pago fue rechazado.',
            default => 'Resultado del pago procesado.',
        };
    }

    protected function normalizarEstadoPago(string $status): string
    {
        $status = strtolower(trim($status));

        return match ($status) {
            'approved', 'aprobado' => 'aprobado',
            'pending', 'pendiente', 'in_process' => 'pendiente',
            'rejected', 'rechazado', 'failed', 'failure', 'fallido' => 'rechazado',
            default => 'pendiente',
        };
    }
}
