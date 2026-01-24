<?php

namespace App\Modules\Api\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;
use App\Modules\Api\Response\ApiResponser;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

final class PasswordResetController extends Controller
{
    use ApiResponser;

    public function sendResetLink(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink($request->only(['email']));

        return $status === Password::RESET_LINK_SENT ?
            $this->success([], 'Enlace de restablecimiento de contraseña enviado a su correo electrónico.') :
            $this->error('No se pudo enviar el enlace. Confirme si su correo electrónico es correcto.', 400);
    }

    public function reset(Request $request): JsonResponse
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::reset(
            $request->only(['email', 'password', 'password_confirmation', 'token']),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60))->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET ?
            $this->success(null, __($status)) :
            $this->error(__($status), 422, ['email' => [__($status)]]);
    }
}