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
        Schema::create('tickets', function (Blueprint $table) {
            $table->string('cod', 10)->primary();
            $table->dateTime('feccre')->useCurrent();
            $table->dateTime('fecpro')->nullable();
            $table->dateTime('feccie')->nullable();
            $table->string('asu', 140);
            $table->string('des', 900);
            $table->string('urlpdf', 30)->nullable();
            $table->string('res', 900)->nullable();
            $table->unsignedBigInteger('idusu')->index();
            $table->unsignedTinyInteger('codesttic')->index()->default(1);
            $table->unsignedTinyInteger('codpritic')->index()->default(2);
            $table->unsignedBigInteger('codres')->index();
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
