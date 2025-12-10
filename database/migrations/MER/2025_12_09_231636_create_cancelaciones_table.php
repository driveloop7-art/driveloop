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
        Schema::create('cancelaciones', function (Blueprint $table) {
            $table->bigIncrements('cod');
            $table->unsignedBigInteger('codres')->index('codres');
            $table->dateTime('fec');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cancelaciones');
    }
};
