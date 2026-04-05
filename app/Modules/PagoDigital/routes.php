<?php

use Illuminate\Support\Facades\Route;
use App\Modules\PagoDigital\Controllers\PagoDigitalController;

Route::prefix('pago-digital')->group(function () {
    Route::get('/{reserva_id?}', [PagoDigitalController::class, 'index'])->name('pago.digital');
    Route::post('/store', [PagoDigitalController::class, 'store'])->name('pago.digital.store');
    Route::get('/factura/{id}', [PagoDigitalController::class, 'downloadInvoice'])->name('pago.digital.invoice');
});