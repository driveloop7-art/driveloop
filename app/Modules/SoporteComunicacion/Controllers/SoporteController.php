<?php

namespace App\Modules\SoporteComunicacion\Controllers;

use App\Modules\SoporteComunicacion\Models\Soporte;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\MER\Ticket;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Exception;


class SoporteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("modules.SoporteComunicacion.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(Soporte $soporte)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Soporte $soporte)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Soporte $soporte)
    {
        //
    }
}