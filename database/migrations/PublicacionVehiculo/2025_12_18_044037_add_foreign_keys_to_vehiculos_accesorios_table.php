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
        Schema::table('vehiculos_accesorios', function (Blueprint $table) {
            $table->foreign(['codveh'], 'vehiculosaccesorios_vehiculos_fk')->references(['cod'])->on('vehiculos')->onUpdate('cascade')->onDelete('no action');
            $table->foreign(['idacc'], 'vehiculosaccesorios_accesorios_fk')->references(['id'])->on('accesorios')->onUpdate('cascade')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehiculos_accesorios', function (Blueprint $table) {
            $table->dropForeign('vehiculosaccesorios_vehiculos_fk');
            $table->dropForeign('vehiculosaccesorios_accesorios_fk');
        });
    }
};