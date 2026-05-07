<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('polizas_servicio', function (Blueprint $table) {
            $table->string('numero_poliza', 50)->nullable()->after('cod');
            $table->string('empresa_aseguradora', 120)->nullable()->after('ase');
            $table->string('tipo_cobertura', 80)->default('Todo Riesgo Temporal')->after('empresa_aseguradora');
            $table->decimal('valor_asegurado', 14, 2)->nullable()->after('tipo_cobertura');
            $table->string('deducible', 120)->nullable()->after('valor_asegurado');
            $table->string('estado', 30)->default('emitida')->after('deducible');
            $table->string('pdf_path')->nullable()->after('estado');
            $table->text('observaciones')->nullable()->after('pdf_path');
        });
    }

    public function down(): void
    {
        Schema::table('polizas_servicio', function (Blueprint $table) {
            $table->dropColumn([
                'numero_poliza',
                'empresa_aseguradora',
                'tipo_cobertura',
                'valor_asegurado',
                'deducible',
                'estado',
                'pdf_path',
                'observaciones',
            ]);
        });
    }
};
