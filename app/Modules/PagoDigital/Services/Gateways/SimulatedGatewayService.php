<?php

namespace App\Modules\PagoDigital\Services\Gateways;

use Illuminate\Support\Str;

class SimulatedGatewayService implements PaymentGatewayInterface
{
    public function createPayment(array $data): array
    {
        $estadoPago = 'aprobado';

        switch ($data['metodo_pago']) {
            case 'card':
                $estadoPago = 'aprobado';
                break;

            case 'transfer':
                $estadoPago = 'pendiente';
                break;

            case 'nequi':
                $telefono = preg_replace('/\D/', '', $data['nequi_telefono'] ?? '');

                if ($telefono === '') {
                    $estadoPago = 'rechazado';
                } else {
                    $ultimoDigito = (int) substr($telefono, -1);
                    $estadoPago = ($ultimoDigito % 2 === 0) ? 'aprobado' : 'rechazado';
                }
                break;

            default:
                $estadoPago = 'rechazado';
                break;
        }

        return [
            'status' => $estadoPago,
            'reference' => 'SIM-' . strtoupper(Str::random(10)),
            'external_payment_id' => null,
            'external_reference' => $data['reserva_id'],
            'status_detail' => 'transaccion_simulada',
            'message' => match ($estadoPago) {
                'aprobado' => 'Pago aprobado en simulación.',
                'pendiente' => 'Pago pendiente en simulación.',
                'rechazado' => 'Pago rechazado en simulación.',
                default => 'Resultado desconocido.',
            },
        ];
    }
}