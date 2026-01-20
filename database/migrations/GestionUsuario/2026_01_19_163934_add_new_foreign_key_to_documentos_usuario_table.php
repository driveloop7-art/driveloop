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
            // Primero eliminamos la llave foránea existente
            $table->dropForeign('docsusuario_users_fk');

            // Luego creamos la nueva llave foránea apuntando a 'id' y no a 'cod'
            $table->foreign(['codusu'], 'docsusuario_users_fk')->references(['id'])->on('users')->onUpdate('cascade')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documentos_usuario', function (Blueprint $table) {
            // Revertimos el cambio: eliminamos la nueva y restauramos la anterior
            $table->dropForeign('docsusuario_users_fk');

            // Restauramos la referencia original a 'cod'
            $table->foreign(['codusu'], 'docsusuario_users_fk')->references(['cod'])->on('users')->onUpdate('cascade')->onDelete('no action');
        });
    }
};
