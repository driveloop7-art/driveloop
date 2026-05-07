<?php

namespace App\Modules\PagoDigital\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MER\Vehiculo;
use App\Models\MER\Reserva;
use App\Modules\PagoDigital\Services\PaymentService;
use App\Modules\PagoDigital\Services\PaymentWebhookService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function __construct(
        protected PaymentService $paymentService,
        protected PaymentWebhookService $paymentWebhookService
    ) {}

    public function checkoutReserva(Request $request): View|\Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'codveh' => 'required|exists:vehiculos,cod',
            'pickup_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after_or_equal:pickup_date',
        ]);

        $vehiculo = Vehiculo::with(['marca', 'linea', 'ciudad', 'fotos', 'combustible'])
            ->findOrFail($request->codveh);

        if (!(bool) $vehiculo->disp) {
            return redirect()->back()->with('error', 'El vehículo ya no se encuentra disponible.');
        }

        $fecini = Carbon::parse($request->pickup_date);
        $fecfin = Carbon::parse($request->return_date);

        $reservaActivaSolapada = Reserva::where('codveh', $vehiculo->cod)
            ->where('codestres', '!=', 3)
            ->where(function ($q) use ($fecini, $fecfin) {
                $q->where('fecini', '<', $fecfin)
                    ->where('fecfin', '>', $fecini);
            })
            ->exists();

        if ($reservaActivaSolapada) {
            return redirect()->back()->with('error', 'El vehículo ya está reservado para esas fechas.');
        }

        $dias = $fecini->diffInDays($fecfin);
        if ($dias < 1) {
            $dias = 1;
        }

        $monto = (float) $vehiculo->prerent * $dias;

        $reserva = new \stdClass();
        $reserva->cod = null;
        $reserva->fecini = $fecini;
        $reserva->fecfin = $fecfin;
        $reserva->vehiculo = $vehiculo;

        $reserva_id = 'TMP-' . now()->format('YmdHis') . '-' . $vehiculo->cod;

        return view('modules.PagoDigital.checkout', [
            'reserva' => $reserva,
            'monto' => $monto,
            'reserva_id' => $reserva_id,
        ]);
    }

    public function procesarPago(Request $request)
    {
        $data = $request->validate([
            'reserva_id' => 'required|string',
            'codveh' => 'required|exists:vehiculos,cod',
            'pickup_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after_or_equal:pickup_date',
            'metodo_pago' => 'required|string|in:card,transfer,nequi',
            'monto' => 'required|numeric|min:1',
            'provider' => 'required|string|in:simulated,mercadopago,wompi',
            'nequi_telefono' => 'nullable|string|max:20',
            'card_numero' => 'nullable|string|max:25',
            'card_nombre' => 'nullable|string|max:120',
            'card_expiry' => 'nullable|string|max:10',
            'card_cvv' => 'nullable|string|max:6',
            'transfer_comprobante' => 'nullable|string|max:255',
        ]);

        $result = $this->paymentService->process($data, auth()->id());

        if ($result['status'] === 'aprobado') {
            return redirect()->route('checkout.exito', $result['reserva_id'])
                ->with('success', $result['message'] ?? 'Pago aprobado correctamente.');
        }

        if ($result['status'] === 'pendiente') {
            return redirect()->route('checkout.pending')
                ->with('success', $result['message'] ?? 'El pago quedó pendiente.');
        }

        if ($result['status'] === 'redirect') {
            return redirect()->away($result['url']);
        }

        return redirect()->route('checkout.error')
            ->with('error', $result['message'] ?? 'No fue posible procesar el pago.');
    }

    public function success($id)
    {
        return view('modules.PagoDigital.success', compact('id'));
    }

    public function failure()
    {
        return view('modules.PagoDigital.failure');
    }

    public function pending()
    {
        return view('modules.PagoDigital.pending');
    }

    public function webhook(Request $request, string $provider)
    {
        $result = $this->paymentWebhookService->handle($provider, $request->all());

        return response()->json($result, 200);
    }
}