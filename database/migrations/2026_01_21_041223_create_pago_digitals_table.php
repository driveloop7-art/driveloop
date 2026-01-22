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
        Schema::create('pago_digitals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reserva_id')->nullable(); // Optional if not linked to a reservation yet
            $table->string('metodo_pago'); // card, pse, nequi
            $table->decimal('monto', 15, 2)->default(0);
            $table->string('moneda', 3)->default('COP');
            $table->string('estado')->default('pendiente'); // pendiente, completado, fallido
            $table->json('datos_proveedor')->nullable(); // card last 4, nequi phone, etc.
            $table->string('transaccion_id')->unique()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pago_digitals');
    }
};
