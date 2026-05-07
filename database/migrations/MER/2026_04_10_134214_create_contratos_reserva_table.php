<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contratos_reserva', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('codres')->unique();
            $table->string('numero_contrato', 50)->unique();
            $table->string('pdf_path')->nullable();
            $table->dateTime('fecha_emision');
            $table->string('estado', 30)->default('generado');
            $table->timestamps();

            $table->foreign('codres')
                ->references('cod')
                ->on('reservas')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contratos_reserva');
    }
};