<?php

namespace App\Modules\GestionUsuario\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminRolesController extends Controller
{
    /**
     * Mostrar la lista de roles.
     */
    public function index()
    {
        $roles = Role::all();
        return view('modules.GestionUsuario.admin.roles.index', compact('roles'));
    }

    /**
     * Mostrar el formulario para editar un rol y sus permisos.
     */
    public function edit(Role $role)
    {
        // Obtener todos los permisos agrupados por módulo (asumiendo formato modulo.accion)
        $permissions = Permission::all()->groupBy(function($perm) {
            $parts = explode('.', $perm->name);
            return count($parts) > 1 ? ucfirst($parts[0]) : 'General';
        });

        return view('modules.GestionUsuario.admin.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Actualizar los permisos asignados a un rol.
     */
    public function update(Request $request, Role $role)
    {


        $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'string|exists:permissions,name'
        ]);

        // Sincronizar los permisos del rol
        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('admin.roles.index')
            ->with('success', "Permisos del rol '{$role->name}' actualizados correctamente.");
    }
}
