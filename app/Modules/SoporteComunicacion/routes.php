<?php

use Illuminate\Support\Facades\Route;
use App\Modules\SoporteComunicacion\Controllers\SoporteController;
use Illuminate\Support\Facades\Storage;
use App\Models\MER\Ticket;

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

Route::middleware(['auth'])->group(function () {
    Route::get('/tickets/{cod}', function ($cod) {

        $ticket = Ticket::findOrFail($cod);

        if (auth()->id() !== $ticket->idusu) {
            abort(403, 'Permiso denegado.');
        }

        if ($ticket->urlpdf === null || !Storage::disk('local')->exists($ticket->urlpdf)) {
            abort(404);
        }

        return response()->file(Storage::disk('local')->path($ticket->urlpdf));
    })->name('tickets');
});