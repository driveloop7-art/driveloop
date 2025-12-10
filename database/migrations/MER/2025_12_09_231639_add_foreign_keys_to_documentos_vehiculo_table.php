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
        Schema::table('documentos_vehiculo', function (Blueprint $table) {
            $table->foreign(['idtipdocveh'], 'docsveh_tipodocveh_fk')->references(['id'])->on('tipos_doc_vehiculo')->onUpdate('cascade')->onDelete('no action');
            $table->foreign(['codveh'], 'docsveh_veh_fk')->references(['cod'])->on('vehiculos')->onUpdate('cascade')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documentos_vehiculo', function (Blueprint $table) {
            $table->dropForeign('docsveh_tipodocveh_fk');
            $table->dropForeign('docsveh_veh_fk');
        });
    }
};
