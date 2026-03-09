<?php

namespace App\Modules\Api\Controllers\Admin;
use App\Models\MER\Reserva; // Importamos el modelo que habla con la tabla de reservas
use App\Http\Controllers\Controller;

class ReservasController extends Controller
{
    /**
     * Devuelve la lista de todos los vehiculos registrados.
     */
    public function index()
    {
        // 1. Eloquent ORM: Le pedimos a la base de datos TODOS los usuarios
        // Nota: En un proyecto real gigante usaríamos paginación (paginate), 
        // pero para empezar, all() está perfecto.
        $reservas = Reserva::all();
        $reservasPreparadas = [];
        foreach ($reservas as $reserva) {
            $reservasPreparadas[] = [
                'cod' => $reserva->cod,
                'fec_realizacion' => $reserva->fecrea,
                'fec_inicio' => $reserva->fecini,
                'fec_fin' => $reserva->fecfin,
                'valor' => $reserva->val,
                'usuario' => $reserva->idusu,
                'vehiculo' => $reserva->vehiculo->marca->des . ' ' . $reserva->vehiculo->linea->des . ' ' . $reserva->vehiculo->mod,
                'estado' => $reserva->estado_reserva->des,
            ];
        }

        // 2. Armamos la respuesta en el formato JSON que nuestra app de Python espera
        return response()->json([
            'status' => 'Success',
            'message' => 'Reservas obtenidascorrectamente',
            'data' => $reservasPreparadas
        ], 200);
    }
}