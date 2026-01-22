<?php
use App\Modules\GestionUsuario\Controllers\DocumentoUsuarioController;
use Illuminate\Support\Facades\Route;

Route::prefix('gestion-usuario')->group(function () {
    Route::get('/', function () {
        return view("modules.GestionUsuario.index");
    })->name('gestion.usuario');
    // Grupo de rutas que requieren autenticación
    Route::middleware(['auth'])->group(function () {
        // Ruta para ver la gestión de documentos
        Route::get('/mis-documentos', [DocumentoUsuarioController::class, 'index'])
            ->name('usuario.documentos.index');
        // Ruta para subir documentos
        Route::post('/mis-documentos/subir', [DocumentoUsuarioController::class, 'store'])
            ->name('usuario.documentos.store');
    });
});
