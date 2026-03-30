<?php

namespace App\Modules\Api\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Modules\Api\Response\ApiResponser;

class UpdatePhoneNumberController extends Controller
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
            'tel' => [
                'required',
                'string',
                'min:10',
                'max:10',
            ],
        ]);

        $telChanged = $user->tel !== $request->tel;

        if ($telChanged) {
            $user->tel = $request->tel;
            $user->save();
            return $this->success(
                $user,
                'Teléfono actualizado correctamente.'
            );
        }

        return $this->success(
            $user,
            'El teléfono proporcionado es el mismo que el actual, no se realizaron cambios.'
        );
    }
}