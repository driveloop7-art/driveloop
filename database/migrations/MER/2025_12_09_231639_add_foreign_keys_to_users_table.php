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
        Schema::table('users', function (Blueprint $table) {
            $table->foreign(['codrol'], 'users_roles_fk')->references(['cod'])->on('roles')->onUpdate('cascade')->onDelete('no action');
            $table->foreign(['numdir'], 'users_direcciones_fk')->references(['num'])->on('direcciones')->onUpdate('cascade')->onDelete('no action');
            $table->foreign(['codciu'], 'users_ciudades_fk')->references(['cod'])->on('ciudades')->onUpdate('cascade')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_ciudades_fk');
            $table->dropForeign('users_roles_fk');
            $table->dropForeign('users_direcciones_fk');
        });
    }
};
