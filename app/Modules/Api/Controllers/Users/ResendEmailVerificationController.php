<?php

namespace App\Modules\Api\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Modules\Api\Response\ApiResponser;

class ResendEmailVerificationController extends Controller
{
    use ApiResponser;

    /**
     * Reenvía el correo de verificación al usuario autenticado.
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

        if ($user->hasVerifiedEmail()) {
            return $this->success(
                null,
                'El correo electrónico ya ha sido verificado.'
            );
        }

        if (method_exists($user, 'sendEmailVerificationNotification')) {
            $user->sendEmailVerificationNotification();
        }

        return $this->success(
            null,
            'Se ha reenviado el enlace de verificación a su correo electrónico.'
        );
    }
}
