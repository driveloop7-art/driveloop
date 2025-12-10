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
        Schema::table('cancelaciones', function (Blueprint $table) {
            $table->foreign(['codres'], 'cancelaciones_reservas_fk')->references(['cod'])->on('reservas')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cancelaciones', function (Blueprint $table) {
            $table->dropForeign('cancelaciones_reservas_fk');
        });
    }
};
