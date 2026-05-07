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
        Schema::table('reservas', function (Blueprint $table) {
            $table->dateTime('fecha_cierre_real')->nullable()->after('fecfin');
            $table->boolean('confirmado_propietario')->default(false)->after('fecha_cierre_real');
            $table->boolean('recibido_buen_estado')->nullable()->after('confirmado_propietario');
            $table->text('observacion_recepcion')->nullable()->after('recibido_buen_estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservas', function (Blueprint $table) {
            $table->dropColumn([
                'fecha_cierre_real',
                'confirmado_propietario',
                'recibido_buen_estado',
                'observacion_recepcion',
            ]);
        });
    }
};