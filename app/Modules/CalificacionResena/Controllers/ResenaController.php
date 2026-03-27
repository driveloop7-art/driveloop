<?php

namespace App\Modules\CalificacionResena\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MER\Resena;
use App\Models\MER\Reserva; // Agregamos el modelo de Reserva
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ResenaController extends Controller
{
    /**
     * Registra la calificación y reseña (RF-001, RF-002, RF-004)
     */
    public function store(Request $request)
    {
        // 1. Validaciones de formulario
        $request->validate([
            'puntuacion' => 'required|integer|between:1,5',    // RF-001
            'des'        => 'required|string|min:20|max:500',  // RF-002
            'codres'     => 'required|exists:reservas,cod',    // Existe la reserva
        ], [
            'des.min' => 'La reseña debe tener al menos 20 caracteres.',
            'des.max' => 'La reseña no debe exceder los 500 caracteres.',
        ]);

        // Buscamos la reserva para las reglas de negocio
        $reserva = Reserva::where('cod', $request->codres)->first();

        // 2. Validar RF-004: Que la reserva esté finalizada (estado 3)
        if ($reserva->codestres != 3) {
            return back()->withErrors(['codres' => 'Solo puedes calificar reservas que ya han sido finalizadas.']);
        }

        // 3. Validar seguridad: Solo quien alquiló puede calificar
        if ($reserva->idus != Auth::id()) {
            return back()->withErrors(['codres' => 'No tienes permiso para calificar esta reserva.']);
        }

        // 4. Prevenir reseñas duplicadas
        $resenaPrevia = Resena::where('codres', $request->codres)->first();
        if ($resenaPrevia) {
            return back()->withErrors(['codres' => 'Ya has calificado esta experiencia anteriormente.']);
        }

        // 5. Guardar en la base de datos
        Resena::create([
            'puntuacion' => $request->puntuacion,
            'des'        => $request->des,
            'fec'        => Carbon::now(),
            'codres'     => $request->codres,
            'estado'     => 'visible',
        ]);

        return back()->with('success', '¡Gracias por calificar el servicio!');

        
    }
    /**
     * RF-006: Visualización de reseñas y panel principal
     */
    /**
     * RF-006: Visualización de reseñas y panel principal
     */
    public function index(Request $request)
    {
        $usuarioActual = Auth::user();

        // CAMBIO AQUÍ: Usamos 'resenas' en lugar de 'resenas_calificaciones'
        $query = Resena::select('resenas.*')
            ->join('reservas', 'resenas.codres', '=', 'reservas.cod')
            ->join('vehiculos', 'reservas.codveh', '=', 'vehiculos.cod')
            ->where('vehiculos.user_id', $usuarioActual->id)
            ->where('resenas.estado', 'visible');

        // Aplicamos los filtros del RF-006
        if ($request->filled('filtro')) {
            switch ($request->filtro) {
                case 'positivas':
                    $query->where('puntuacion', '>=', 4);
                    break;
                case 'negativas':
                    $query->where('puntuacion', '<=', 3);
                    break;
                case 'con_texto':
                    $query->whereNotNull('des')->where('des', '!=', '');
                    break;
            }
        }

        // Ordenamos por las más recientes primero (RF-006)
        $resenas = $query->orderBy('fec', 'desc')->paginate(10);

        // Retornamos la vista correcta
        return view('modules.CalificacionResena.index', compact('resenas')); 
    
    }
}