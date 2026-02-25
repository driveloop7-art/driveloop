<?php

namespace App\Modules\SoporteComunicacion\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\MER\Ticket;
use App\Models\MER\EstadoTicket;
use App\Models\MER\PrioridadTicket;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class ValidacionTicketsController extends Controller
{
    public function index(Request $request)
    {
        $query = Ticket::query();

        if ($request->filled('estado')) {
            $query->where('codesttic', $request->estado);
        }

        if ($request->filled('fecha')) {
            $query->whereDate('feccre', $request->fecha);
        }

        if ($request->filled('prioridad')) {
            $query->where('codpritic', $request->prioridad);
        }

        if ($request->filled('codigo')) {
            $query->where('cod', $request->codigo);
        }

        $allTickets = $query->get();
        $estados = EstadoTicket::all();
        $prioridades = PrioridadTicket::all();

        return view("modules.SoporteComunicacion.soporte.index", compact('allTickets', 'estados', 'prioridades'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'res' => 'required_without:pdf|nullable|string|max:900',
            'pdf' => 'required_without:res|nullable|file|mimes:pdf|max:5120',
            'cod' => 'required|string|max:10',
        ]);

        $ticket = Ticket::findOrFail($request->cod);

        $ruta = null;
        if ($request->hasFile('pdf')) {
            $file = $request->file('pdf');
            $ruta = $file->storeAs('tickets', "{$ticket->cod}_res.pdf", 'local');
            $ticket->urlpdfres = $ruta;
            $ticket->save();
        }

        $ticket->update([
            'res' => $data['res'] === null ? "Ticket con PDF de respuesta adjunto" : $data['res'],
            'codesttic' => '3',
            'feccie' => now()
        ]);

        if (auth()->user()->hasrole('Administrador')) {
            $ticket->idususop = auth()->id();
            $ticket->save();
        }
        return redirect()->route('tickets.soporte.index')->with(['message' => "El ticket {$ticket->cod} se ha cerrado correctamente"]);
    }

    public function enproceso(string $cod): View
    {
        $ticket = Ticket::findOrFail($cod);
        if (auth()->user()->hasrole('Soporte')) {
            if ($ticket->idususop === null) {
                $ticket->update([
                    'codesttic' => '2',
                    'fecpro' => now(),
                    'idususop' => auth()->id()
                ]);
            }
        }
        return view("modules.SoporteComunicacion.soporte.enproceso", compact('ticket'));
    }

    public function cerrados(string $cod): View
    {
        $ticket = Ticket::findOrFail($cod);
        return view("modules.SoporteComunicacion.soporte.cerrados", compact('ticket'));
    }

    public function updatePrioridad(Request $request): JsonResponse
    {
        $ticket = Ticket::findOrFail($request->cod);
        $ticket->update([
            'codpritic' => $request->prioridad
        ]);
        return response()->json([
            'message' => "El ticket {$ticket->cod} se ha actualizado correctamente"
        ]);
    }
}