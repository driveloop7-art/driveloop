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

            // Si intenta entrar a una ruta protegida sin documentos, lo mandamos a subir documentos.
            return redirect()->route('usuario.documentos.index')
                ->with('error', 'Para realizar esta acción, primero debes verificar tu identidad y licencia.');
        }
        return $next($request);
    }
}
