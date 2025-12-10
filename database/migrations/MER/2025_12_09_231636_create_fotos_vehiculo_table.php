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
        Schema::create('fotos_vehiculo', function (Blueprint $table) {
            $table->integer('cod', true);
            $table->string('nom', 45);
            $table->string('ruta', 150);
            $table->string('dim', 45);
            $table->string('mim', 25);
            $table->integer('pes');
            $table->unsignedBigInteger('codveh')->nullable()->index('codveh');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fotos_vehiculo');
    }
};
