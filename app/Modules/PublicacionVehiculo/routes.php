<?php

use Illuminate\Support\Facades\Route;
use App\Modules\PublicacionVehiculo\Controllers\VehController;
use App\Modules\PublicacionVehiculo\Controllers\VehPublicacion;
use App\Modules\PublicacionVehiculo\Controllers\VehiculoDocumentosController;

Route::get('/', [VehController::class, 'autosDestacados'])->name('home');

Route::prefix('publi-vehiculo')->group(function () {

    Route::middleware(['auth'])->group(function () {

        Route::get('/publicacion-vehiculo', [VehController::class, 'index'])
            ->name('publicacion.vehiculo');

        Route::post('/publicacion-vehiculo', [VehController::class, 'store'])
            ->name('publicacion.vehiculo.store');

        Route::get('/vehiculos/{codveh}/documentos', [VehiculoDocumentosController::class, 'create'])
            ->name('vehiculo.documentos.create');

        Route::post('/vehiculos/documentos', [VehiculoDocumentosController::class, 'store'])
            ->name('vehiculo.documentos.store');

        Route::post('/vehiculos/{codveh}/documentos', [VehiculoDocumentosController::class, 'store'])
            ->name('vehiculos.doc.store');

        Route::get('/mis-vehiculos', [VehPublicacion::class, 'index'])
            ->name('vehiculos.index');

        Route::get('/vehiculos/{cod}/editar', [VehPublicacion::class, 'edit'])
            ->name('vehiculos.edit');

        Route::put('/vehiculos/{cod}', [VehPublicacion::class, 'update'])
            ->name('vehiculos.update');

        Route::delete('/vehiculos/{cod}', [VehPublicacion::class, 'destroy'])
            ->name('vehiculos.destroy');
            
        Route::get('/rentar/{codveh}', [VehController::class, 'rentarDirecto'])
            ->middleware(['auth'])
            ->name('vehiculo.rentar.directo');
    });

    Route::get('/marcas/{cod}/lineas', [VehController::class, 'lineasPorMarca'])
        ->name('marcas.lineas');

    Route::get('/departamentos/{coddep}/ciudades', [VehController::class, 'ciudadesPorDepartamento'])
        ->name('departamentos.ciudades');

    Route::post('/vehiculos/{codveh}/publicar', [VehController::class, 'activar'])
        ->middleware(['auth', 'verified_docs'])
        ->name('vehiculo.publicar');

    Route::middleware(['auth', 'verified'])->group(function () {

        Route::post('/vehiculos/{codveh}/activar', [VehController::class, 'activar'])
            ->name('vehiculo.activar');

        Route::get('/mis-vehiculos-aprobados', [VehController::class, 'misVehiculosAprobados'])
            ->name('vehiculos.aprobados');
    });
});
