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
        Schema::table('fotos_vehiculo', function (Blueprint $table) {
            $table->foreign(['codveh'], 'fotosveh_veh_fk')->references(['cod'])->on('vehiculos')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fotos_vehiculo', function (Blueprint $table) {
            $table->dropForeign('fotosveh_veh_fk');
        });
    }
};
