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
        Schema::create('documentos_vehiculo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->smallinteger('idtipdocveh')->index();
            $table->string('numdoc', 45);
            $table->string('empexp', 150);
            $table->string('descdoc', 150);
            $table->unsignedBigInteger('codveh')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos_vehiculo');
    }
};
