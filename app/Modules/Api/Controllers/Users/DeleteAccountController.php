<?php

namespace App\Modules\Api\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\GestionUsuario\services\UserAnonymizationService;

class DeleteAccountController extends Controller
{
    public function __invoke(Request $request, UserAnonymizationService $anonymizationService)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        // Usar el servicio para anonimizar
        $anonymizationService->execute($request->user());

        // La API recorta el acceso a los tokens de sanctum
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Cuenta eliminada y datos anonimizados correctamente.'
        ], 200);
    }
}
