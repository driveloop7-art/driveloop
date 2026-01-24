<?php

namespace App\Modules\Api\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Modules\Api\Response\ApiResponser;

class LogoutUserController extends Controller
{
    use ApiResponser;
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return $this->success(null, 'Sesión cerrada correctamente');
    }
}
