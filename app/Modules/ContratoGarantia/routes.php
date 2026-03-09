<?php

use Illuminate\Support\Facades\Route;
use App\Modules\ContratoGarantia\Controllers\ContratoGarantiaController;

Route::prefix('contrato-garantia')->group(function () {
    Route::get('/', [ContratoGarantiaController::class, 'index'])->name('contrato.garantia');
    Route::get('/descargar/{codReserva}', [ContratoGarantiaController::class, 'generarContrato'])->name('contrato.descargar');
    Route::get('/acta-entrega/{codReserva}', [ContratoGarantiaController::class, 'descargarActaEntrega'])->name('acta.entrega.descargar');
    Route::post('/enviar/{codReserva}', [ContratoGarantiaController::class, 'enviarContrato'])->name('contrato.enviar');
});
