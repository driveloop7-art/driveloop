<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/**
 * Seeder para crear roles y permisos de Spatie Laravel Permission.
 * 
 * Roles disponibles:
 * - Usuario: Rol básico para clientes
 * - Administrador: Acceso completo al sistema
 * - Soporte: Acceso a tickets y gestión de usuarios
 * 
 * ============================================================
 * CÓMO AGREGAR NUEVOS PERMISOS:
 * ============================================================
 * 
 * Opción 1: Agregar al array $permissions en este seeder y re-ejecutar:
 *   php artisan db:seed --class=RolesAndPermissionsSeeder
 * 
 * Opción 2: Desde Tinker (consola):
 *   php artisan tinker
 *   >>> use Spatie\Permission\Models\Permission;
 *   >>> Permission::create(['name' => 'nuevo.permiso', 'guard_name' => 'web']);
 * 
 * Opción 3: Desde la interfaz de administración (si está implementada)
 * 
 * Opción 4: En código (controlador, comando, etc.):
 *   Permission::firstOrCreate(['name' => 'nuevo.permiso', 'guard_name' => 'web']);
 * 
 * ============================================================
 * CONVENCIÓN DE NOMBRES DE PERMISOS:
 * ============================================================
 * Usamos el formato: modulo.accion
 * Ejemplos: vehiculo.crear, reserva.aprobar, ticket.responder
 */
class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiar caché de permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ============================================================
        // DEFINIR PERMISOS POR MÓDULO
        // Agregar nuevos permisos aquí siguiendo el formato 'modulo.accion'
        // ============================================================
        $permissions = [
            // Vehículos
            'vehiculo.ver',
            'vehiculo.crear',
            'vehiculo.editar',
            'vehiculo.eliminar',
            
            // Reservas
            'reserva.ver',
            'reserva.crear',
            'reserva.aprobar',
            'reserva.cancelar',
            
            // Tickets
            'ticket.ver',
            'ticket.responder',
            'ticket.cerrar',
            'ticket.eliminar',
            
            // Usuarios
            'usuario.ver',
            'usuario.editar',
            'usuario.verificar-docs',
            
            // Administración
            'admin.roles',
            'admin.permisos',
        ];

        // Crear todos los permisos
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // ============================================================
        // CREAR ROLES Y ASIGNAR PERMISOS
        // ============================================================
        
        // Usuario: permisos básicos para clientes
        $usuarioRole = Role::firstOrCreate(['name' => 'Usuario', 'guard_name' => 'web']);
        $usuarioRole->syncPermissions([
            'vehiculo.ver',
            'reserva.ver',
            'reserva.crear',
            'ticket.ver',
        ]);

        // Administrador: todos los permisos del sistema
        $adminRole = Role::firstOrCreate(['name' => 'Administrador', 'guard_name' => 'web']);
        $adminRole->syncPermissions($permissions);

        // Soporte: permisos de gestión de tickets y usuarios
        $soporteRole = Role::firstOrCreate(['name' => 'Soporte', 'guard_name' => 'web']);
        $soporteRole->syncPermissions([
            'vehiculo.ver',
            'reserva.ver',
            'reserva.aprobar',
            'reserva.cancelar',
            'ticket.ver',
            'ticket.responder',
            'ticket.cerrar',
            'usuario.ver',
            'usuario.verificar-docs',
        ]);
    }
}
