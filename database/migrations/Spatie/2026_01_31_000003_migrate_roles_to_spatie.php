<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Models\MER\User;

/**
 * Migra los datos de roles del sistema anterior (codrol) al nuevo sistema de Spatie.
 * 
 * Mapeo de roles:
 * - codrol = 1 → 'Usuario'
 * - codrol = 2 → 'Administrador'
 * - codrol = 3 → 'Soporte'
 * 
 * Esta migración DEBE ejecutarse DESPUÉS de la migración de Spatie y del seeder.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Obtener usuarios con sus roles anteriores (antes de eliminar la columna)
        $users = DB::table('users')
            ->select('id', 'codrol')
            ->get();

        // Mapear códigos de rol a nombres
        $roleMap = [
            1 => 'Usuario',
            2 => 'Administrador',
            3 => 'Soporte',
        ];

        // Asignar roles de Spatie a cada usuario
        foreach ($users as $userData) {
            $roleName = $roleMap[$userData->codrol] ?? 'Usuario';
            
            // Asegurarse de que el rol existe en el sistema de Spatie
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
            
            // Insertar directamente en la tabla pivot
            DB::table('model_has_roles')->insertOrIgnore([
                'role_id' => $role->id,
                'model_type' => User::class,
                'model_id' => $userData->id,
            ]);
        }
    }

    public function down(): void
    {
        // Eliminar todas las asignaciones de roles de usuarios
        DB::table('model_has_roles')
            ->where('model_type', User::class)
            ->delete();
    }
};
