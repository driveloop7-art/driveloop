<?php

use Illuminate\Support\Facades\Route;
use App\Modules\PagoDigital\Controllers\PagoDigitalController;
use App\Modules\PagoDigital\Controllers\PaymentController;

// RUTA PARA EL WEBHOOK DE MERCADO PAGO
Route::post('/webhook/mercadopago', [PagoDigitalController::class, 'handleWebhook']);

Route::prefix('pago-digital')->group(function () {
    Route::get('/', [PagoDigitalController::class, 'index'])->name('pago.digital');
});

Route::get('/checkout/{monto}', [PaymentController::class, 'checkout'])->name('checkout');

Route::get('/pago-exitoso', [PaymentController::class, 'success'])->name('pago.success');
Route::get('/pago-fallido', [PaymentController::class, 'failure'])->name('pago.failure');
Route::get('/pago-pendiente', [PaymentController::class, 'pending'])->name('pago.pending');

Route::get('/', fn() => view('home'))->name('home');

require __DIR__ . '/breeze/routes.php';
require __DIR__ . '/breeze/auth.php';
require app_path('Modules/PagoDigital/routes.php');

foreach (glob(app_path('Modules/*/routes.php')) as $route) {
    require $route;
}
