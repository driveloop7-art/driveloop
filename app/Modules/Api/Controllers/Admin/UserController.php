<?php

namespace App\Modules\Api\Controllers\Admin;
use App\Models\MER\User; // Importamos el modelo que habla con la tabla de usuarios
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Devuelve la lista de todos los usuarios registrados.
     */
    public function index()
    {
        // 1. Eloquent ORM: Le pedimos a la base de datos TODOS los usuarios
        // Nota: En un proyecto real gigante usaríamos paginación (paginate), 
        // pero para empezar, all() está perfecto.
        $usuarios = User::all();

        // 2. Armamos la respuesta en el formato JSON que nuestra app de Python espera
        return response()->json([
            'status' => 'Success',
            'message' => 'Usuarios obtenidos correctamente',
            'data' => $usuarios
        ], 200);
    }
}