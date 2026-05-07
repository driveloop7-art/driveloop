<?php

use Illuminate\Support\Facades\Route;
use App\Modules\PagoDigital\Controllers\PagoDigitalController;
use App\Modules\PagoDigital\Controllers\PaymentController;

Route::middleware(['web', 'auth'])->group(function () {

    Route::post('/checkout/reserva', [PaymentController::class, 'checkoutReserva'])
        ->name('checkout.reserva');

    Route::post('/checkout/pagar', [PaymentController::class, 'procesarPago'])
        ->name('checkout.pagar');

    Route::get('/checkout/exito/{id}', [PaymentController::class, 'success'])
        ->name('checkout.exito');

    Route::get('/checkout/error', [PaymentController::class, 'failure'])
        ->name('checkout.error');

    Route::get('/checkout/pendiente', [PaymentController::class, 'pending'])
        ->name('checkout.pending');
});

Route::post('/pagos/webhook/{provider}', [PaymentController::class, 'webhook'])
    ->name('pagos.webhook');