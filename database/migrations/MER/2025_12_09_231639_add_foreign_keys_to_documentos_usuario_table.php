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
        Schema::table('documentos_usuario', function (Blueprint $table) {
            $table->foreign(['idtipdocusu'], 'docsusuario_tipodocusuario_fk')->references(['id'])->on('tipos_doc_usuario')->onUpdate('cascade')->onDelete('no action');
            $table->foreign(['codusu'], 'docsusuario_users_fk')->references(['id'])->on('users')->onUpdate('cascade')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documentos_usuario', function (Blueprint $table) {
            $table->dropForeign('docsusuario_tipodocusuario_fk');
            $table->dropForeign('docsusuario_users_fk');
        });
    }
};
