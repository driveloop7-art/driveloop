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
        Schema::table('reembolsos', function (Blueprint $table) {
            $table->foreign(['codcan'], 'reembolsos_cancelaciones_fk')->references(['cod'])->on('cancelaciones')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reembolsos', function (Blueprint $table) {
            $table->dropForeign('reembolsos_cancelaciones_fk');
        });
    }
};
