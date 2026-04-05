<?php

namespace App\Modules\Api\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GetReservationsController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        // Eager load relationships to prevent N+1 query problems
        $reservations = $user->reservas()->with([
            'estado_reserva',
            'vehiculo.marca',
            'vehiculo.linea'
        ])->get();

        // Transform the collection to return only the specific fields requested
        $formattedReservations = $reservations->map(function ($reserva) {
            return [
                'cod' => $reserva->cod,
                'fecrea' => $reserva->fecrea,
                'fecini' => $reserva->fecini,
                'fecfin' => $reserva->fecfin,
                'valor_reserva' => $reserva->val,
                'estado_reserva' => $reserva->estado_reserva?->des ?? null,
                'marca_vehiculo' => $reserva->vehiculo?->marca?->des ?? null,
                'linea_vehiculo' => $reserva->vehiculo?->linea?->des ?? null,
                'modelo_vehiculo' => $reserva->vehiculo?->mod ?? null,
            ];
        });

        return response()->json($formattedReservations);
    }
}