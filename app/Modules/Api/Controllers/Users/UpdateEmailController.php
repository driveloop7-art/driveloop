<?php

namespace App\Modules\Api\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Modules\Api\Response\ApiResponser;

class UpdateEmailController extends Controller
{
    use ApiResponser;

    /**
     * Actualiza el correo electrónico del usuario y reenvía el correo de verificación.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user) {
            return $this->error('Usuario no autenticado', 401);
        }

        $request->validate([
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(get_class($user))->ignore($user->id),
            ],
        ]);

        $emailChanged = $user->email !== $request->email;

        if ($emailChanged) {
            $user->email = $request->email;
            $user->email_verified_at = null;
            $user->save();

            // Reenviar el correo de verificación
            // Nota: El modelo de usuario debe usar el trait MustVerifyEmail de Laravel
            // para que tenga disponible este método.
            if (method_exists($user, 'sendEmailVerificationNotification')) {
                $user->sendEmailVerificationNotification();
            }

            return $this->success(
                $user,
                'Correo electrónico actualizado. Se ha enviado un nuevo enlace de verificación a su nuevo correo.'
            );
        }

        return $this->success(
            $user,
            'El correo electrónico proporcionado es el mismo que el actual, no se realizaron cambios.'
        );
    }
}
