<?php

use Illuminate\Support\Facades\Route;
use App\Modules\BusquedaReservas\Controllers\ReservaController;

Route::prefix('busqueda-reservas')->name('busqueda-reservas')->group(function () {
    Route::get('/', [ReservaController::class, 'index'])->name('index');
});