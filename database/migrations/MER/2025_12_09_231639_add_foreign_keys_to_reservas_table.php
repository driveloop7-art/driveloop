<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reservas', function (Blueprint $table) {
            $table->foreign(['idusu'], 'reservas_users_fk')->references(['id'])->on('users')->onUpdate('cascade')->onDelete('no action');
            $table->foreign(['codveh'], 'reservas_vehiculo_fk')->references(['cod'])->on('vehiculos')->onUpdate('cascade')->onDelete('no action');
            $table->foreign(['codestres'], 'reservas_estadosreserva_fk')->references(['cod'])->on('estados_reserva')->onUpdate('cascade')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservas', function (Blueprint $table) {
            $table->dropForeign('reservas_users_fk');
            $table->dropForeign('reservas_vehiculo_fk');
            $table->dropForeign('reservas_estadosreserva_fk');
        });
    }
};
