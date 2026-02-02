<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

/**
 * Renombra la tabla 'roles' existente a 'roles_legacy' para evitar
 * conflictos con la tabla 'roles' que creará Spatie Permission.
 * 
 * Esta migración DEBE ejecutarse ANTES de la migración de Spatie.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('roles')) {
            Schema::rename('roles', 'roles_legacy');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('roles_legacy')) {
            Schema::rename('roles_legacy', 'roles');
        }
    }
};
