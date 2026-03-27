<?php

use App\Modules\GestionUsuario\breeze\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Modules\GestionUsuario\Controllers\AdminPanelController;

Route::get('/dashboard', [AdminPanelController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
