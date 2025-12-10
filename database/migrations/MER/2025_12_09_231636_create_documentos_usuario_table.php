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
        Schema::create('documentos_usuario', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('idtipdocusu')->index('idtipdocusu');
            $table->string('num', 45);
            $table->unsignedBigInteger('codusu')->nullable()->index('codusu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos_usuario');
    }
};
