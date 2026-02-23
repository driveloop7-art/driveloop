<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('documentos_vehiculo', function (Blueprint $table) {
            // Estado de la verificación. Por defecto es PENDIENTE al subirlo.
            $table->enum('estado', ['PENDIENTE', 'APROBADO', 'RECHAZADO'])
                ->default('PENDIENTE');
            // Mensaje opcional para explicar por qué se rechazó (si aplica)
            $table->text('mensaje_rechazo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documentos_vehiculo', function (Blueprint $table) {
            $table->dropColumn(['estado', 'mensaje_rechazo']);
        });
    }
};
