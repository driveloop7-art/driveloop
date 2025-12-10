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
        Schema::table('prioridades_ticket', function (Blueprint $table) {
            $table->foreign(['codtic'], 'prioticket_ticket_fk')->references(['cod'])->on('tickets')->onUpdate('cascade')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prioridades_ticket', function (Blueprint $table) {
            $table->dropForeign('prioticket_ticket_fk');
        });
    }
};
