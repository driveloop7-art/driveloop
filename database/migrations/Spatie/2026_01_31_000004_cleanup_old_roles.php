<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Limpieza del sistema de roles anterior.
 * Elimina la columna codrol de users y la tabla roles_legacy.
 * 
 * Esta migración DEBE ejecutarse AL FINAL, después de migrar los datos.
 */
return new class extends Migration
{
    public function up(): void
    {
        $driver = DB::getDriverName();

        Schema::disableForeignKeyConstraints();

        // En MySQL (Azure) podemos eliminar la columna sin problemas.
        // En SQLite, lo omitimos para evitar errores de recreación de tabla.
        if ($driver !== 'sqlite') {
            Schema::table('users', function (Blueprint $table) {
                if (Schema::hasColumn('users', 'codrol')) {
                    // Intentamos eliminar el foreign key primero por su nombre estándar o personalizado
                    try {
                        $table->dropForeign('users_roles_fk');
                    } catch (\Exception $e) { /* Ignorar si no existe con ese nombre */ }
                    
                    $table->dropColumn('codrol');
                }
            });
        }

        // Eliminar la tabla legacy (esto funciona en ambos)
        Schema::dropIfExists('roles_legacy');

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        // Restaurar tabla roles_legacy
        Schema::create('roles_legacy', function (Blueprint $table) {
            $table->tinyIncrements('cod');
            $table->string('des', 60);
        });

        // Restaurar columna codrol en users
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedTinyInteger('codrol')->index('codrol')->default(1);
            $table->foreign(['codrol'], 'users_roles_fk')
                ->references(['cod'])
                ->on('roles_legacy')
                ->onUpdate('cascade')
                ->onDelete('no action');
        });
    }
};
