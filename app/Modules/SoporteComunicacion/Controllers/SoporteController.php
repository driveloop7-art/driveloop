<?php

namespace App\Modules\SoporteComunicacion\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Exception;
use Illuminate\Support\Facades\Storage;
use App\Models\MER\Ticket;

class SoporteController extends Controller
{
    public function index()
    {
        return view("modules.SoporteComunicacion.index");
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'asu' => 'required|string|max:140',
            'des' => 'required|string|max:900',
            'pdf' => 'file|mimes:pdf|max:5120',
            'codres' => 'required|exists:reservas,cod'
        ]);

        do {
            $cod = Str::upper(Str::random(10));
        } while (Ticket::where('cod', $cod)->exists());

        $data['cod'] = $cod;
        $data['idusu'] = $request->user()->id;

        $ticket = Ticket::create($data);

        if ($request->hasFile('pdf')) {
            $file = $request->file('pdf');
            $ruta = $file->storeAs('tickets', "$cod.pdf", 'local');
            $ticket->urlpdf = $ruta;
            $ticket->save();
        }

        return redirect()->route('dashboard')->with(['message' => "El ticket se ha creado correctamente con el código $cod"]);
    }

    public function edit($cod): JsonResponse
    {
        $ticket = Ticket::find($cod);
        if ($ticket === null) {
            throw new \Exception("El ticket $cod no existe.");
        }

        $ticket->update([
            'res' => 'Ticket cerrado por el usuario',
            'codesttic' => '3',
            'feccie' => now()
        ]);
        return response()->json([
            'message' => "El ticket $cod se ha cerrado correctamente"
        ]);
    }

    public function GetPDF(string $cod, bool $pdfres)
    {
        $ticket = Ticket::findOrFail($cod);

        if (auth()->user()->hasRole('Usuario')) {
            if (auth()->id() !== $ticket->idusu)
                return abort(403, 'Permiso denegado.');
        }

        $url = $pdfres ? $ticket->urlpdfres : $ticket->urlpdf;

        if ($url === null || !Storage::disk('local')->exists($url))
            return abort(404);

        return response()->file(Storage::disk('local')->path($url));
    }
}