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
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->bigIncrements('cod');
            $table->string('vin', 17);
            $table->year('mod');
            $table->string('col', 30);
            $table->unsignedTinyInteger('pas');
            $table->unsignedSmallInteger('cil')->nullable();
            $table->integer('codpol')->index('codpol');
            $table->unsignedSmallInteger('codmar')->index('codmar');
            $table->unsignedInteger('codlin')->index('codlin');
            $table->unsignedSmallInteger('codcla')->index('codcla');
            $table->unsignedSmallInteger('codcom')->index('codcom');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiculos');
    }
};
