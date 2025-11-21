<?php

use Illuminate\Support\Facades\Route;
use App\Modules\SoporteComunicacion\Controllers\SoporteController;

Route::prefix('soporte-comunicacion')->name('soporte-comunicacion')->group(function () {
    Route::get('/', [SoporteController::class, 'index'])->name('index');
});