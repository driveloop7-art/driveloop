<?php

use Illuminate\Support\Facades\Route;
use App\Modules\PagosDigitales\Controllers\PagosController;

Route::prefix('pagos-digitales')->name('pagos-digitales')->group(function () {
    Route::get('/', [PagosController::class, 'index'])->name('index');
});