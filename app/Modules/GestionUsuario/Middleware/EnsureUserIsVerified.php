<?php
namespace App\Modules\GestionUsuario\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class EnsureUserIsVerified
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        // 1. Verificar si el usuario está logueado y si NO está verificado
        if ($user && !$user->isVerified()) {

            // Si intenta entrar a una ruta protegida sin documentos, redirigir al home y mostrar modal.
            return redirect('/')
                ->with('show_verification_modal', true);
        }

        /**
         * 2. Reutilización para Vehículos:
         * Si la ruta tiene un parámetro 'codveh' o similar, verificar documentos del vehículo.
         */
        $vehId = $request->route('codveh') ?: $request->route('vehiculo');
        if ($vehId) {
            $vehiculo = $vehId instanceof \App\Models\MER\Vehiculo 
                ? $vehId 
                : \App\Models\MER\Vehiculo::find($vehId);

            if ($vehiculo && $vehiculo->user_id == Auth::id() && !$vehiculo->isVerified()) {
                return redirect('/')
                    ->with('show_vehicle_verification_modal', true)
                    ->with('unverified_vehiculo_id', $vehiculo->cod);
            }
        }

        return $next($request);
    }
}
