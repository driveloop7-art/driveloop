<?php

use Illuminate\Support\Facades\Route;
use App\Mail\PagoRecibido;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

Route::get('/', fn() => view('home'));

require __DIR__ . '/breeze/routes.php';
require __DIR__ . '/breeze/auth.php';

foreach (glob(app_path('Modules/*/routes.php')) as $route) {
    require $route;
}

// -----------------------------------------------------------------------
// WEBHOOK DE MERCADO PAGO
// -----------------------------------------------------------------------


Route::post('/webhook', function (Request $request) {
    $data = $request->all();

    // Verificamos si es una notificación de pago
    if (isset($data['type']) && $data['type'] === 'payment') {
        
        // EXTRAEMOS EL ID DEL PAGO (según el formato de Mercado Pago que vimos en tus imágenes)
        $paymentId = $data['data']['id'] ?? 'N/A'; 

        try {
            // PASAMOS EL ID AL CONSTRUCTOR DEL MAIL
            Mail::to('andresjohan200511@gmail.com')->send(new PagoRecibido($paymentId));
            
            Log::info("¡Correo enviado con éxito para el pago #" . $paymentId . "!");
        } catch (\Exception $e) {
            Log::error("Error enviando correo: " . $e->getMessage());
        }
    }

    return response()->json(['status' => 'ok'], 200);
});