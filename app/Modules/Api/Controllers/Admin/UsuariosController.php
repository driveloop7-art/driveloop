<?php

namespace App\Modules\Api\Controllers\Admin;
use App\Models\MER\User;
use App\Http\Controllers\Controller;

class UsuariosController extends Controller
{
    public function index_desktop()
    {
        $usuarios = User::all();
        $usuariosDTO = $usuarios->map(function ($usuario) {
            return [
                'id' => $usuario->id,
                'nom' => $usuario->nom,
                'ape' => $usuario->ape,
                'email' => $usuario->email,
                'tel' => $usuario->tel,
                'is_active' => $usuario->is_active,
            ];
        });

        return response()->json([
            'status' => 'Success',
            'message' => 'Usuarios obtenidos correctamente',
            'data' => $usuariosDTO
        ], 200);
    }
}