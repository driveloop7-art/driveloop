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
            $table->increments('cod', true);
            $table->dateTime('feccre')->useCurrent();
            $table->dateTime('feccie')->nullable();
            $table->string('asu', 140);
            $table->text('des');
            $table->string('res', 20);
            $table->unsignedBigInteger('codusu')->index('codusu');
            $table->integer('codesttic')->index('codesttic')->default(1);
            $table->integer('codpritic')->index('codpritic')->default(1);
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
