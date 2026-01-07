<?php

use Illuminate\Support\Facades\Route;
use App\Modules\SoporteComunicacion\Controllers\SoporteController;

//// Solo se ingresa con inicio de sesion
// Route::prefix('soporte-comunicacion')->name('soporte.comunicacion')->group(function () {
//     Route::get('/', function() { return view("modules.SoporteComunicacion.index"); })->middleware(['auth', 'verified']);
// });

//// Agregar el codigo al layout navigation.blade.php en la sección "<!-- Navigation Links -->" y "<!-- Responsive Navigation Menu -->"
// <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
//     <x-nav-link :href="route('soporte.comunicacion')"  :active="request()->routeIs('soporte.comunicacion')">
//         {{ __('Soporte') }}
//     </x-nav-link>
// </div>

Route::prefix('soporte-comunicacion')->group(function () {
    Route::get('/', [SoporteController::class, 'index'])->name('soporte.index');
    Route::post('/{id}', [SoporteController::class, 'edit'])->name('soporte.edit');
    Route::post('/', [SoporteController::class, 'store'])->name('soporte.store');
    Route::fallback(fn() => abort(404));
});