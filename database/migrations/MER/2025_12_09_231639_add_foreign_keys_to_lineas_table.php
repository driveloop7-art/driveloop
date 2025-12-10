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
        Schema::table('lineas', function (Blueprint $table) {
            $table->foreign(['codmar'], 'lineas_marca_fk')->references(['cod'])->on('marcas')->onUpdate('cascade')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lineas', function (Blueprint $table) {
            $table->dropForeign('lineas_marca_fk');
        });
    }
};
