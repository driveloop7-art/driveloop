<?php

namespace App\Modules\Api\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use App\Models\MER\User;
use Illuminate\Http\Request;
use App\Modules\Api\Response\ApiResponser;
use App\Modules\Api\Response\UserDTO;

class AuthenticatedSessionController extends Controller
{
    use ApiResponser;
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->error('Credenciales incorrectas', 422);
        }

        $token = $user->createToken($request->device_name, expiresAt: now()->addDay())->plainTextToken;
        $userDTO = new UserDTO(
            $user->nom,
            $user->email,
            $token,
            $user->email_verified_at,
        );

        return $this->success([
            'user' => $userDTO->toArray(),
        ], 'Login exitoso');
    }

    public function getUser(Request $request): JsonResponse
    {
        $userDTO = new UserDTO(
            $request->user()->nom,
            $request->user()->email,
            $request->user()->currentAccessToken()->token,
            $request->user()->email_verified_at,
        );
        return $this->success([
            'user' => $userDTO->toArray(),
        ], 'User exitoso');
    }
}