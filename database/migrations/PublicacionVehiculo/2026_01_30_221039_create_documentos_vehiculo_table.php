<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documentos_vehiculo', function (Blueprint $table) {


            $table->id();

            $table->unsignedBigInteger('idtipdocveh');


            $table->string('numdoc', 60);
            $table->string('empexp', 120)->nullable();
            $table->string('descdoc', 255)->nullable();

     
            $table->unsignedBigInteger('codveh');


            $table->index('idtipdocveh');
            $table->index('codveh');


            $table->foreign('codveh', 'docsveh_veh_fk')
                ->references('cod')->on('vehiculos')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documentos_vehiculo');
    }
};
