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
            $table->foreignId('reserva_id')->nullable()->constrained('reservas');
            $table->foreignId('payment_method_id')->constrained('payment_methods');
            $table->decimal('monto', 15, 2)->default(0);
            $table->string('moneda', 3)->default('COP');
            $table->foreignId('payment_status_id')->default(1)->constrained('payment_statuses'); // Default to 'pendiente' (id 1)
            $table->json('datos_proveedor')->nullable();
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
