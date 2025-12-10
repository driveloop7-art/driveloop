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
        Schema::create('reservas', function (Blueprint $table) {
            $table->bigIncrements('cod');
            $table->dateTime('fecrea')->useCurrent();
            $table->dateTime('fecini');
            $table->dateTime('fecfin');
            $table->decimal('val', 12)->nullable();
            $table->unsignedBigInteger('codusu')->index('codusu');
            $table->unsignedBigInteger('codveh')->index('codveh');
            $table->unsignedTinyInteger('codestres')->index('codestres');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
