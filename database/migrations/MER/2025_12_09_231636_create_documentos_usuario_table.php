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
        Schema::create('documentos_usuario', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('idtipdocusu')->index();
            $table->string('num', 45);
            $table->unsignedBigInteger('codusu')->nullable()->index();
            //Nuevos campos
            // Ruta relativa donde se almacenará el anverso 
            // Se usa string 255 es suficiente para rutas relativas.
            $table->string('url_anverso', 255)->nullable();
            // Ruta relativa donde se almacenará el reverso 
            $table->string('url_reverso', 255)->nullable();

            // Estado de la verificación. Por defecto es PENDIENTE al subirlo.
            $table->enum('estado', ['PENDIENTE', 'APROBADO', 'RECHAZADO'])
                ->default('PENDIENTE');

            // Mensaje opcional para explicar por qué se rechazó (si aplica)
            $table->text('mensaje_rechazo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos_usuario');
    }
};
