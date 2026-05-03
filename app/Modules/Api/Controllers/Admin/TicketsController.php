<?php

namespace App\Modules\Api\Controllers\Admin;
use App\Models\MER\Ticket;
use App\Http\Controllers\Controller;

class TicketsController extends Controller
{
    public function index_desktop()
    {
        $tickets = Ticket::all();
        $ticketsDTO = $tickets->map(fn($ticket) => [
            'cod' => $ticket->cod,
            'asu' => $ticket->asu,
            'des' => $ticket->des,
            'res' => $ticket->res,
            'feccre' => $ticket->feccre->format('Y-m-d H:i:s'),
            'fecpro' => $ticket->fecpro?->format('Y-m-d H:i:s'),
            'feccie' => $ticket->feccie?->format('Y-m-d H:i:s'),
            'codres' => $ticket->codres,
            'estado' => $ticket->estado_ticket->des,
            'prioridad' => $ticket->prioridad_ticket->des,
            'usuario_nombre' => $ticket->user->nom,
            'usuario_apellido' => $ticket->user->ape,
            'soporte_nombre' => $ticket->user_soporte->nom ?? 'Sin asignar',
            'soporte_apellido' => $ticket->user_soporte->ape ?? 'Sin asignar',
        ]);

        return response()->json([
            'status' => 'Success',
            'message' => 'Tickets obtenidos correctamente',
            'data' => $ticketsDTO
        ], 200);
    }
}