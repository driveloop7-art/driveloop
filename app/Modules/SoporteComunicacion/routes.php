<?php

use Illuminate\Support\Facades\Route;
use App\Modules\SoporteComunicacion\Controllers\ScoreController;
use App\Modules\SoporteComunicacion\Controllers\SoporteController;
use App\Modules\SoporteComunicacion\Controllers\ValidacionTicketsController;

Route::prefix('soporte-comunicacion')->group(function () {

    Route::get('/', [SoporteController::class, 'index'])->name('soporte.index');
    Route::post('/', [SoporteController::class, 'store'])->name('soporte.store');
    Route::post('/{id}', [SoporteController::class, 'edit'])->name('soporte.edit');

    Route::middleware(['auth'])->prefix('tickets/adjuntos/pdf')->group(function () {
        Route::get('/{cod?}', [SoporteController::class, 'GetPDF'])->name('tickets.adjuntos')->defaults('pdfres', false);
        Route::get('/respuesta/{cod?}', [SoporteController::class, 'GetPDF'])->name('tickets.adjuntos.respuesta')->defaults('pdfres', true);
        Route::get('/export/{cod?}', [SoporteController::class, 'ExportPDF'])->name('tickets.export.pdf');
    });

    Route::middleware(['role:Soporte|Administrador', 'auth'])->prefix('tickets/soporte')->group(function () {
        Route::get('/', [ValidacionTicketsController::class, 'index'])->name('tickets.soporte.index');
        Route::post('/', [ValidacionTicketsController::class, 'store'])->name('tickets.soporte.store');
        Route::get('/en-proceso/{cod}', [ValidacionTicketsController::class, 'enproceso'])->name('tickets.soporte.enproceso');
        Route::get('/cerrados/{cod}', [ValidacionTicketsController::class, 'cerrados'])->name('tickets.soporte.cerrados');
        Route::post('/update-prioridad', [ValidacionTicketsController::class, 'updatePrioridad'])->name('tickets.soporte.updatePrioridad');
    });

    Route::post('/tickets/score/results', [ScoreController::class, 'store'])->name('tickets.score.results')->middleware('auth');
    Route::fallback(fn() => abort(404));
});
