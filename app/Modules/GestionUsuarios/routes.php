<?php

use Illuminate\Support\Facades\Route;
use App\Modules\GestionUsuarios\Controllers\UsuariosController;

Route::prefix('gestion-usuarios')->name('gestion-usuarios')->group(function () {
    Route::get('/', [UsuariosController::class, 'index'])->name('index');
});