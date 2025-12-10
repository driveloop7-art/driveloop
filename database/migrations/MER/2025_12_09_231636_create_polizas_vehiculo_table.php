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
        Schema::create('polizas_vehiculo', function (Blueprint $table) {
            $table->integer('cod', true);
            $table->text('ase');
            $table->dateTime('fini')->nullable();
            $table->dateTime('ffin')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('polizas_vehiculo');
    }
};
