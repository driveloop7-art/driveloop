<?php

use Illuminate\Support\Facades\Route;
use App\Modules\InformacionEmpresa\Controllers\InformacionEmpresaController;

Route::prefix('informacion')->group(function () {
    Route::get('/nosotros', [InformacionEmpresaController::class, 'nosotros'])
        ->name('informacion.nosotros');

    Route::get('/servicios', [InformacionEmpresaController::class, 'servicios'])
        ->name('informacion.servicios');

    Route::get('/como-funciona', [InformacionEmpresaController::class, 'comoFunciona'])
        ->name('informacion.como-funciona');
});