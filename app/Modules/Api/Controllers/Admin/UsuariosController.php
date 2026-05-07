<?php

namespace App\Modules\Api\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MER\User;
use App\Models\MER\Vehiculo;
use App\Modules\Api\Response\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UsuariosController extends Controller
{
    use ApiResponser;
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

    public function user_store_desktop(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', Rules\Password::defaults()],
                'device_name' => 'required',
                'tel' => ['required', 'numeric', 'max_digits:10', 'min_digits:10'],
                'is_active' => ['required', 'boolean'],
            ]);

            $user = User::create([
                'nom' => $request->name,
                'ape' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'tel' => $request->tel,
                'is_active' => $request->is_active,
            ]);

            $user->assignRole('Soporte');

            return response()->json([
                'status' => 'Success',
                'message' => 'Usuario registrado exitosamente',
                'data' => ""
            ], 200);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 500);
        }
    }

    public function user_update_desktop(Request $request)
    {
        try {
            $request->validate([
                'name' => 'string|max:255',
                'last_name' => 'string|max:255',
                'email' => 'string|email|max:255',
                'tel' => 'numeric|max_digits:10|min_digits:10',
                'is_active' => 'boolean',
            ]);

            $user = User::find($request->id);
            $user->nom = $request->name;
            $user->ape = $request->last_name;

            if ($user->email != $request->email) {
                if (User::where('email', $request->email)->exists()) {
                    return $this->error('El email ya existe', 422);
                }
                $user->email = $request->email;
            }

            $user->tel = $request->tel;
            $user->is_active = $request->is_active;
            $user->save();

            return response()->json([
                'status' => 'Success',
                'message' => 'Usuario actualizado exitosamente',
                'data' => ""
            ], 200);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 500);
        }
    }

    public function user_delete_desktop($id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'Usuario no encontrado',
                    'data' => null
                ], 404);
            }

            $tieneReservas = $user->reservas()->count();
            if ($tieneReservas > 0) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'No se puede eliminar el usuario porque tiene reserva(s) asociadas',
                    'data' => null
                ], 400);
            }

            $tieneTickets = $user->tickets()->count();
            if ($tieneTickets > 0) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'No se puede eliminar el usuario porque tiene ticket(s) asociados',
                    'data' => null
                ], 400);
            }

            $veh = Vehiculo::where('user_id', $user->id)->first();
            if ($veh) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'No se puede eliminar el usuario porque tiene vehiculo(s) asociados',
                    'data' => null
                ], 400);
            }

            $user->delete();
            return response()->json([
                'status' => 'Success',
                'message' => 'Usuario eliminado exitosamente',
                'data' => ""
            ], 200);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 500);
        }
    }
}