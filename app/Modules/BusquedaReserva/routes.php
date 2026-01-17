<?php

use Illuminate\Support\Facades\Route;
use App\Modules\BusquedaReserva\Controllers\BusquedaReservaController;

Route::prefix('busqueda-reserva')->group(function () {
    Route::match(['get', 'post'], '/', [BusquedaReservaController::class, 'index'])->name('busqueda.reserva');
});