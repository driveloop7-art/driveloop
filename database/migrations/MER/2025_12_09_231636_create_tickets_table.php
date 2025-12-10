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
        Schema::create('tickets', function (Blueprint $table) {
            $table->bigIncrements('cod');
            $table->dateTime('feccre')->useCurrent();
            $table->dateTime('feccie')->nullable();
            $table->string('asu', 140);
            $table->text('des');
            $table->string('res', 20);
            $table->unsignedBigInteger('codusu')->index('codusu');
            $table->integer('codesttic')->nullable()->index('codesttic');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
