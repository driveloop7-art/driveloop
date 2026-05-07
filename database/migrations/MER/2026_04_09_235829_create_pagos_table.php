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
        Schema::create('pagos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('codres');
            $table->unsignedBigInteger('idusu');
            $table->string('referencia', 100)->unique();
            $table->string('metodo', 30);
            $table->decimal('monto', 12, 2);
            $table->string('estado', 20);
            $table->string('moneda', 10)->default('COP');
            $table->timestamp('fecha_pago')->nullable();
            $table->json('detalle')->nullable();
            $table->timestamps();

            $table->foreign('codres')
                ->references('cod')
                ->on('reservas')
                ->onDelete('cascade');

            $table->foreign('idusu')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->index('codres');
            $table->index('idusu');
            $table->index('estado');
            $table->index('metodo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};