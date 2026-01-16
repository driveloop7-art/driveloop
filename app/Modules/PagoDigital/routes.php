<?php

use Illuminate\Support\Facades\Route;
use App\Modules\PagoDigital\Controllers\PagoDigitalController;

Route::prefix('pago-digital')->group(function () {
    Route::get('/', function() { return view("modules.PagoDigital.index"); })->name('pago.digital');
});