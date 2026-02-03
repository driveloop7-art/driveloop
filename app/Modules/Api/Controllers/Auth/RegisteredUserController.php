<?php

namespace App\Modules\Api\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\MER\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Modules\Api\Response\ApiResponser;
use App\Modules\Api\Response\UserDTO;

class RegisteredUserController extends Controller
{
    use ApiResponser;
    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'device_name' => 'required',
        ]);

        $user = User::create([
            'nom' => $request->name,
            'ape' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('Soporte');

        $token = $user->createToken($request->device_name, expiresAt: now()->addDay())->plainTextToken;
        $userDTO = new UserDTO(
            $user->nom,
            $user->email,
            $token,
            $user->email_verified_at,
        );

        $user->sendEmailVerificationNotification();

        return $this->success([
            'user' => $userDTO->toArray(),
        ], 'Usuario registrado exitosamente', 201);
    }
}
