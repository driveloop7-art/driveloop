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
        Schema::table('vehiculos', function (Blueprint $table) {
            $table->foreign(['codpol'], 'vehiculos_polizaveh_fk')->references(['cod'])->on('polizas_vehiculo')->onUpdate('cascade')->onDelete('no action');
            $table->foreign(['codmar'], 'vehiculos_marcas_fk')->references(['cod'])->on('marcas')->onUpdate('cascade')->onDelete('no action');
            $table->foreign(['codlin'], 'vehiculos_lineas_fk')->references(['cod'])->on('lineas')->onUpdate('cascade')->onDelete('no action');
            $table->foreign(['codcla'], 'vehiculos_clases_fk')->references(['cod'])->on('clases')->onUpdate('cascade')->onDelete('no action');
            $table->foreign(['codcom'], 'vehiculos_combustibles_fk')->references(['cod'])->on('combustibles')->onUpdate('cascade')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehiculos', function (Blueprint $table) {
            $table->dropForeign('vehiculos_polizaveh_fk');
            $table->dropForeign('vehiculos_marcas_fk');
            $table->dropForeign('vehiculos_lineas_fk');
            $table->dropForeign('vehiculos_clases_fk');
            $table->dropForeign('vehiculos_combustibles_fk');
        });
    }
};
