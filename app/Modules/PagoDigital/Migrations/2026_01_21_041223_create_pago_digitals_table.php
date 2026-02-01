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
        if (!Schema::hasTable('pago_digitals')) {
            Schema::create('pago_digitals', function (Blueprint $table) {
                $table->id();
                $table->foreignId('reserva_id')->nullable()->constrained('reservas');
                $table->string('metodo_pago');
                $table->decimal('monto', 15, 2)->default(0);
                $table->string('moneda', 3)->default('COP');
                $table->string('estado_pago')->default('pendiente');
                $table->json('datos_proveedor')->nullable();
                $table->string('transaccion_id')->unique()->nullable();
                $table->timestamps();
            });
        } else {
            Schema::table('pago_digitals', function (Blueprint $table) {
                if (!Schema::hasColumn('pago_digitals', 'moneda')) {
                    $table->string('moneda', 3)->default('COP')->after('monto');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pago_digitals');
    }
};
