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
        Schema::table('tickets', function (Blueprint $table) {
            $table->foreign(['codusu'], 'tickets_users_fk')->references(['cod'])->on('users')->onUpdate('cascade')->onDelete('no action');
            $table->foreign(['codesttic'], 'tickets_estadotickets_fk')->references(['cod'])->on('estados_ticket')->onUpdate('cascade')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign('tickets_users_fk');
            $table->dropForeign('tickets_estadotickets_fk');
        });
    }
};
