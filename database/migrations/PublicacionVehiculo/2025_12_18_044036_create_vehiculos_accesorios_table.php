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
        Schema::create('vehiculos_accesorios', function (Blueprint $table) {
            $table->bigIncrements('codveh')->index('codveh');
            $table->unsignedTinyInteger('idacc')->index('idacc');
            $table->primary(['codveh', 'idacc'], 'dual_primary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiculos_accesorios');
    }
};