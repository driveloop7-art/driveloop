<?php

use Illuminate\Support\Facades\Route;
use App\Modules\PublicacionVehiculo\Controllers\VehController;
use App\Modules\PublicacionVehiculo\Controllers\vehPublicacion;
use App\Modules\PublicacionVehiculo\Controllers\VehiculoDocumentosController;

// Se modifica la ruta principal / para que apunte al método autosDestacados del controlador
Route::get('/', [VehController::class, 'autosDestacados'])->name('home');

Route::prefix('publi-vehiculo')->group(function () {
    Route::get('/publicacion-vehiculo', [VehController::class, 'index'])
        ->name('publicacion.vehiculo');

    Route::post('/publicacion-vehiculo', [VehController::class, 'store'])
        ->name('publicacion.vehiculo.store');

    Route::get('/marcas/{cod}/lineas', [VehController::class, 'lineasPorMarca'])
        ->name('marcas.lineas');

    // Route::get('/docVeh', [VehController::class, 'vehiculo'])
    //     ->name('vehiculo-ver');

    Route::get('/vehiculos/{codveh}/documentos', [VehiculoDocumentosController::class, 'create'])
        ->middleware(['auth'])
        ->name('vehiculo.documentos.create');

    Route::post('/vehiculos/documentos', [VehiculoDocumentosController::class, 'store'])
        ->name('vehiculo.documentos.store');

    Route::get('/departamentos/{coddep}/ciudades', [VehController::class, 'ciudadesPorDepartamento'])
        ->name('departamentos.ciudades');

    // Ruta para publicar el vehículo, protegida por el middleware de verificación
    Route::post('/vehiculos/{codveh}/publicar', [VehController::class, 'activar'])
        ->middleware(['auth', 'verified_docs'])
        ->name('vehiculo.publicar');

    Route::middleware(['auth', 'verified'])->group(function () {

        Route::post(
            '/vehiculos/{codveh}/activar',
            [VehController::class, 'activar']
        )->name('vehiculo.activar');

        Route::get(
            '/mis-vehiculos-aprobados',
            [VehController::class, 'misVehiculosAprobados']
        )->name('vehiculos.aprobados');
    });

    // Mis vehículos (CRUD básico)
    Route::get('/mis-vehiculos', [VehPublicacion::class, 'index'])->name('vehiculos.index');
    Route::get('/vehiculos/{cod}/editar', [VehPublicacion::class, 'edit'])->name('vehiculos.edit');
    Route::put('/vehiculos/{cod}', [VehPublicacion::class, 'update'])->name('vehiculos.update');

    // Documentos del vehículo
    // Route::get('/vehiculos/{codveh}/documentos', [VehiculoDocumentosController::class, 'create'])
    //     ->name('vehiculos.documentos.create');

    Route::post('/vehiculos/{codveh}/documentos', [VehiculoDocumentosController::class, 'store'])
        ->name('vehiculos.doc.store');
        
});
