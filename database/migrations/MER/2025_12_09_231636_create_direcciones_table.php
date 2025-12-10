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
        Schema::create('direcciones', function (Blueprint $table) {
            $table->bigIncrements('num');
            $table->string('via', 20);
            $table->unsignedSmallInteger('numpri');
            $table->string('numpre', 10)->nullable();
            $table->string('sufpri', 10)->nullable();
            $table->unsignedSmallInteger('numsec')->nullable();
            $table->string('compri', 30)->nullable();
            $table->string('comsec', 30)->nullable();
            $table->string('sufsec', 10)->nullable();
            $table->unsignedInteger('codciu')->index('codciu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direcciones');
    }
};
