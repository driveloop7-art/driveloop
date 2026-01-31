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
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->unsignedBigInteger('cod', true);
            $table->unsignedBigInteger('user_id');
            $table->string('vin', 17);
            $table->year('mod');
            $table->string('col', 30);
            $table->unsignedTinyInteger('pas');
            $table->unsignedSmallInteger('cil')->nullable();
            $table->integer('codpol')->index();
            $table->unsignedSmallInteger('codmar')->index();
            $table->unsignedInteger('codlin')->index();
            $table->unsignedSmallInteger('codcla')->index();
            $table->unsignedSmallInteger('codcom')->index();
            $table->unsignedInteger('codciu')->index();
            $table->decimal('prerent', 12, 2);
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
