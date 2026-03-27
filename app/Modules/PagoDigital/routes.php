<?php

use Illuminate\Support\Facades\Route;
use App\Modules\PagoDigital\Controllers\PagoDigitalController;
//use App\Http\Controllers\PaymentController;
use App\Modules\PagoDigital\Controllers\PaymentController;


Route::prefix('pago-digital')->group(function () {
    Route::get('/', [PagoDigitalController::class, 'index'])->name('pago.digital');
});




/* Route::get('/checkout', function () {
    return view('modules.PagoDigital.checkout');
})->name('checkout'); */
/* Route::get('/checkout', [PaymentController::class, 'checkout'])->name('checkout'); */

Route::get('/checkout/{monto}', [PaymentController::class, 'checkout'])->name('checkout');


Route::get('/pago-exitoso', function () {
    return view('modules.PagoDigital.success');
})->name('pago.exitoso');

Route::get('/pago-fallido', function () {
    return view('modules.PagoDigital.failure');
})->name('pago.fallido');

Route::get('/pago-pendiente', function () {
    return view('modules.PagoDigital.pending');
})->name('pago.pendiente');









