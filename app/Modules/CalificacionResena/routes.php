<?php

use Illuminate\Support\Facades\Route;
use App\Modules\CalificacionResena\Controllers\ResenaController;

Route::middleware(['web', 'auth'])->group(function () {
    
    // ESTA ES LA RUTA QUE SOLUCIONA TU ERROR (RF-006)
    Route::get('/resenas/panel', [ResenaController::class, 'index'])->name('calificacion.resena');
    
    // La ruta que ya teníamos para guardar (RF-001, RF-002, RF-004)
    Route::post('/resenas', [ResenaController::class, 'store'])->name('resenas.store');

});