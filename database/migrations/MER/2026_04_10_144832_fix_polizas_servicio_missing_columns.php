<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('polizas_servicio', function (Blueprint $table) {
            if (!Schema::hasColumn('polizas_servicio', 'numero_poliza')) {
                $table->string('numero_poliza', 50)->nullable()->after('cod');
            }

            if (!Schema::hasColumn('polizas_servicio', 'empresa_aseguradora')) {
                $table->string('empresa_aseguradora', 120)->nullable()->after('ase');
            }

            if (!Schema::hasColumn('polizas_servicio', 'tipo_cobertura')) {
                $table->string('tipo_cobertura', 80)->default('Todo Riesgo Temporal')->after('empresa_aseguradora');
            }

            if (!Schema::hasColumn('polizas_servicio', 'valor_asegurado')) {
                $table->decimal('valor_asegurado', 14, 2)->nullable()->after('tipo_cobertura');
            }

            if (!Schema::hasColumn('polizas_servicio', 'deducible')) {
                $table->string('deducible', 120)->nullable()->after('valor_asegurado');
            }

            if (!Schema::hasColumn('polizas_servicio', 'estado')) {
                $table->string('estado', 30)->default('emitida')->after('deducible');
            }

            if (!Schema::hasColumn('polizas_servicio', 'pdf_path')) {
                $table->string('pdf_path')->nullable()->after('estado');
            }

            if (!Schema::hasColumn('polizas_servicio', 'observaciones')) {
                $table->text('observaciones')->nullable()->after('pdf_path');
            }
        });
    }

    public function down(): void
    {
        Schema::table('polizas_servicio', function (Blueprint $table) {
            $cols = [
                'numero_poliza',
                'empresa_aseguradora',
                'tipo_cobertura',
                'valor_asegurado',
                'deducible',
                'estado',
                'pdf_path',
                'observaciones',
            ];

            foreach ($cols as $col) {
                if (Schema::hasColumn('polizas_servicio', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};