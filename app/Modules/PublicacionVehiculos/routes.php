<?php

use Illuminate\Support\Facades\Route;
use App\Modules\PublicacionVehiculos\Controllers\VehiculosController;

Route::prefix('publicacion-vehiculos')->name('publicacion-vehiculos')->group(function () {
    Route::get('/', [VehiculosController::class, 'index'])->name('index');
});