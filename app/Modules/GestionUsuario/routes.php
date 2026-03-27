<?php

use App\Modules\GestionUsuario\Controllers\DocumentoUsuarioController;
use App\Modules\GestionUsuario\Controllers\AdminRolesController;
use App\Modules\GestionUsuario\Controllers\ValidacionDocumentosController;
use Illuminate\Support\Facades\Route;

Route::prefix('gestion-usuario')->group(function () {
    // Grupo de rutas que requieren autenticación
    Route::middleware(['auth'])->group(function () {
        // Ruta para ver la gestión de documentos
        Route::get('/mis-documentos', [DocumentoUsuarioController::class, 'index'])
            ->name('usuario.documentos.index');
        // Ruta para subir documentos
        Route::post('/mis-documentos/subir', [DocumentoUsuarioController::class, 'store'])
            ->name('usuario.documentos.store');

        // RUTAS DE ADMINISTRACIÓN DE ROLES (Spatie)
        // Solo accesibles por usuarios con rol de Administrador
        Route::middleware(['role:Administrador'])->prefix('admin')->group(function () {
            Route::get('/roles', [AdminRolesController::class, 'index'])->name('admin.roles.index');
            Route::get('/roles/{role}/edit', [AdminRolesController::class, 'edit'])->name('admin.roles.edit');
            Route::put('/roles/{role}', [AdminRolesController::class, 'update'])->name('admin.roles.update');
        });

        // RUTAS DE SOPORTE (Validación de Documentos)
        Route::middleware(['role:Soporte|Administrador'])->prefix('soporte')->group(function () {
            // Usuarios
            Route::get('/validacion', [ValidacionDocumentosController::class, 'index'])->name('soporte.docs.index');
            Route::get('/validacion/{user}', [ValidacionDocumentosController::class, 'show'])->name('soporte.docs.show');
            Route::post('/validacion/{documento}/aprobar', [ValidacionDocumentosController::class, 'approve'])->name('soporte.docs.approve');
            Route::post('/validacion/{documento}/rechazar', [ValidacionDocumentosController::class, 'reject'])->name('soporte.docs.reject');

            // Vehículos (Nuevas)
            Route::get('/validacion-vehiculos', [\App\Modules\GestionUsuario\Controllers\ValidacionVehiculosController::class, 'index'])->name('soporte.vehiculos.index');
            Route::get('/validacion-vehiculos/{vehiculo}', [\App\Modules\GestionUsuario\Controllers\ValidacionVehiculosController::class, 'show'])->name('soporte.vehiculos.show');
            Route::post('/validacion-vehiculos/{documento}/aprobar', [\App\Modules\GestionUsuario\Controllers\ValidacionVehiculosController::class, 'approve'])->name('soporte.vehiculos.approve');
            Route::post('/validacion-vehiculos/{documento}/rechazar', [\App\Modules\GestionUsuario\Controllers\ValidacionVehiculosController::class, 'reject'])->name('soporte.vehiculos.reject');
        });
    });
});
