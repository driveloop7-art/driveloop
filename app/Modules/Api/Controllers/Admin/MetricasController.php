<?php

namespace App\Modules\Api\Controllers\Admin;
use App\Models\MER\User;
use App\Models\MER\Vehiculo;
use App\Models\MER\Ticket;
use App\Models\MER\Reserva;
use App\Http\Controllers\Controller;

class MetricasController extends Controller
{
    public function index_desktop()
    {
        $usuarios = User::all();
        $vehiculos = Vehiculo::all();
        $tickets = Ticket::all();
        $reservas = Reserva::all();

        $metricasDTO = [
            'usuarios' => $usuarios->count(),
            'vehiculos' => $vehiculos->count(),
            'vehiculos_disponibles' => $vehiculos->where('disp', true)->count(),
            'tickets_abiertos' => $tickets->where('codesttic', 1)->count(),
            'reservas' => $reservas->count()
        ];

        return response()->json([
            'status' => 'Success',
            'message' => 'Métricas obtenidas correctamente',
            'data' => $metricasDTO
        ], 200);
    }
}