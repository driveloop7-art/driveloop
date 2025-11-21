<?php

use Illuminate\Support\Facades\Route;
use App\Modules\ContratosGarantias\Controllers\ContratosController;

Route::prefix('contratos-garantias')->name('contratos-garantias')->group(function () {
    Route::get('/', [ContratosController::class, 'index'])->name('index');
});