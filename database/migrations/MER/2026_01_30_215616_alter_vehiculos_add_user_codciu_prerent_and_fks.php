<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehiculos', function (Blueprint $table) {

            $table->foreignId('user_id')
                ->after('cod')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete(); 

            $table->unsignedInteger('codciu')
                ->after('codcom')
                ->index();

            $table->decimal('prerent', 12, 2)
                ->after('codciu');


            $table->foreign('codpol', 'vehiculos_codpol_fk')
                ->references('cod')->on('polizas_vehiculo')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreign('codmar', 'vehiculos_codmar_fk')
                ->references('cod')->on('marcas')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreign('codlin', 'vehiculos_codlin_fk')
                ->references('cod')->on('lineas')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreign('codcla', 'vehiculos_codcla_fk')
                ->references('cod')->on('clases')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreign('codcom', 'vehiculos_codcom_fk')
                ->references('cod')->on('combustibles') 
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreign('codciu', 'vehiculos_codciu_fk')
                ->references('cod')->on('ciudades')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('vehiculos', function (Blueprint $table) {

            
            $table->dropForeign('vehiculos_codciu_fk');
            $table->dropForeign('vehiculos_codcom_fk');
            $table->dropForeign('vehiculos_codcla_fk');
            $table->dropForeign('vehiculos_codlin_fk');
            $table->dropForeign('vehiculos_codmar_fk');
            $table->dropForeign('vehiculos_codpol_fk');
            $table->dropForeign(['user_id']); 

           
            $table->dropColumn(['user_id', 'codciu', 'prerent']);
        });
    }
};
