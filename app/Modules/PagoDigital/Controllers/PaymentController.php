<?php

namespace App\Modules\PagoDigital\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Exceptions\MPApiException;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function checkout(Request $request, $monto): View
    {
        MercadoPagoConfig::setAccessToken(env('MERCADO_PAGO_ACCESS_TOKEN'));
        $client = new PreferenceClient();
        $base = config('app.url');
        try {
            $preferenceData = [
                "items" => [
                    [
                        "title"       => "Reserva de vehículo",
                        "quantity"    => 1,
                        "unit_price"  => (float) $monto,
                        "currency_id" => "COP",
                    ]
                ],

                "back_urls" => [
                    "success" => $base . "/pago-exitoso",
                    "failure" => $base . "/pago-fallido",
                    "pending" => $base . "/pago-pendiente"
                ],
                "auto_return" => "approved",
                "binary_mode" => true,
            ];

            $preference = $client->create($preferenceData);

            return view('modules.PagoDigital.checkout', ['preference' => $preference, 'monto' => $monto]);
        } catch (MPApiException $e) {

            dd($e->getApiResponse()->getContent());
        }
    }

    public function success(Request $request)
    {
        $payment_id = $request->get('payment_id');
        return redirect()->route('home');
    }

    public function failure(Request $request)
    {
        return view('modules.PagoDigital.failure');
    }

    public function pending(Request $request)
    {
        $payment_id = $request->get('payment_id');
        return view('modules.PagoDigital.pending', compact('payment_id'));
    }
}
