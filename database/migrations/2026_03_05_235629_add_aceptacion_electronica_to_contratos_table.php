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
        Schema::table('contratos', function (Blueprint $table) {
            $table->boolean('aceptado_arrendatario')->default(false);
            $table->timestamp('fecha_aceptacion_arrendatario')->nullable();
            $table->string('ip_arrendatario')->nullable();
            $table->text('user_agent_arrendatario')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contratos', function (Blueprint $table) {
            $table->dropColumn([
                'aceptado_arrendatario',
                'fecha_aceptacion_arrendatario',
                'ip_arrendatario',
                'user_agent_arrendatario'
            ]);
        });
    }
};
