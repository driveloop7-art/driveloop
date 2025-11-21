<?php

use Illuminate\Support\Facades\Route;
use App\Modules\CalificacionesResenas\Controllers\ResenasController;

Route::prefix('calificaciones-resenas')->name('calificaciones-resenas')->group(function () {
    Route::get('/', [ResenasController::class, 'index'])->name('index');
});