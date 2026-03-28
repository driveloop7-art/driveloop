<?php

namespace App\Modules\Api\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\MER\User;
use Illuminate\Http\Request;
use App\Modules\Api\Response\ApiResponser;
use App\Modules\Api\Response\UserDTO;

class GetUserController extends Controller
{
    use ApiResponser;

    /**
     * Retorna la información del usuario en función del token recibido (el cual vincula a su ID)
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        // El middleware (ej. auth:sanctum) ya se encarga de validar el token 
        // y recuperar el usuario, por lo que el ID viene implícito aquí.
        /** @var User|null $user */
        $user = $request->user();

        if (!$user) {
            return $this->error('Usuario no autenticado o no encontrado', 401);
        }

        // Construimos el DTO para mantener tu estándar de respuesta
        $userDTO = new UserDTO(
            $user->nom,
            $user->email,
            $user->currentAccessToken() ? $user->currentAccessToken()->token : '',
            $user->email_verified_at,
        );

        // 'success' de tu ApiResponser retorna: { status: 'Success', message: '...', data: [...] }
        // Esto permite que tu frontend capture directamente response.data.data
        return $this->success(
            $userDTO->toArray(),
            'Información del usuario obtenida exitosamente'
        );
    }
}