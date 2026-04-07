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
            $table->id();
            $table->unsignedBigInteger('reserva_id');
            $table->unsignedBigInteger('user_id');
            $table->decimal('monto', 12, 2);
            $table->string('metodo_pago'); // tarjeta, transferencia, nequi
            $table->string('estado_pago')->default('pendiente'); // pendiente, aprobado, rechazado
            $table->json('detalles')->nullable(); // Para guardar info específica (nombre, teléfono, comprobante, etc.)
            $table->timestamps();

            // Relaciones si existen las tablas correspondientes
            $table->foreign('reserva_id')->references('cod')->on('reservas')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
