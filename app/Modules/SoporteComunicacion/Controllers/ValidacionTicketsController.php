<?php

namespace App\Modules\SoporteComunicacion\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\MER\Ticket;
use Illuminate\Contracts\View\View;

class ValidacionTicketsController extends Controller
{
    public function index()
    {
        $allTickets = Ticket::all();
        return view("modules.SoporteComunicacion.soporte.index", compact('allTickets'));
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
}