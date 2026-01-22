<?php

use Illuminate\Support\Facades\Route;
use App\Modules\PagoDigital\Controllers\PagoDigitalController;

Route::prefix('pago-digital')->group(function () {
    Route::get('/', [PagoDigitalController::class, 'index'])->name('pago.digital');
    Route::post('/process', [PagoDigitalController::class, 'store'])->name('pago.digital.process');
    Route::get('/resultado/{id}', [PagoDigitalController::class, 'resultado'])->name('pago.digital.resultado');
});
