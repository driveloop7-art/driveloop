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
        Schema::create('prioridades_ticket', function (Blueprint $table) {
            $table->integer('cod', true);
            $table->string('des', 45);
            $table->unsignedBigInteger('codtic')->nullable()->index('codtic');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prioridades_ticket');
    }
};
