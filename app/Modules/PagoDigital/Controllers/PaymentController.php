<?php

namespace App\Modules\PagoDigital\Controllers;

use App\Http\Controllers\Controller; // Importa el controlador base de Laravel
use Illuminate\Http\Request;
use Illuminate\View\View;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Exceptions\MPApiException;

class PaymentController extends Controller
{
    public function checkout(Request $request, $monto): View
    {
        // Configuramos el token desde el ENV
        MercadoPagoConfig::setAccessToken(env('MERCADO_PAGO_ACCESS_TOKEN'));
        
        $client = new PreferenceClient();

        try {
            $preference = $client->create([
                "items" => [
                    [
                        "title"       => "Mi producto",
                        "quantity"    => 1,
                        "unit_price"  => (float) $monto, //2500.00, 
                        "currency_id" => "COP",
                        "category_id" => "others", 
                    ]
                ],
                "back_urls" => [
                    "success" => route('pago.exitoso'),
                    "failure" => route('pago.fallido'),
                    "pending" => route('pago.pendiente'),                    
                ],
                "auto_return" => null, 
                "binary_mode" => true,
            ]);

            return view('modules.PagoDigital.checkout', ['preference' => $preference, 'monto' => $monto]);

        } catch (MPApiException $e) {
            dd($e->getApiResponse()->getContent()); 
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function success(Request $request)
    {
        $payment_id = $request->get('payment_id');
        return view('modules.PagoDigital.success', compact('payment_id'));
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
