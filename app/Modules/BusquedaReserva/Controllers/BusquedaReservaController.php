<?php

namespace App\Modules\BusquedaReserva\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use App\Models\MER\Vehiculo;

class BusquedaReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $vehiculos = [];

        if ($request->isMethod('post')) {
            // 1. Validaciones
            $validator = Validator::make($request->all(), [
                'pickup_date' => 'required|date|after_or_equal:today',
                'return_date' => 'required|date|after:pickup_date',
                // 'marca' => 'nullable|exists:marcas,cod', // Opcional
            ], [
                'pickup_date.after_or_equal' => 'La fecha de recogida no puede ser en el pasado.',
                'return_date.after' => 'La fecha de entrega debe ser posterior a la de recogida.'
            ]);

            if ($validator->fails()) {
                return redirect('/')
                    ->withErrors($validator)
                    ->withInput();
            }

            // 2. Query
            $query = Vehiculo::query();
            // Filtros
            if ($request->filled('marca')) {
                $query->where('codmar', $request->marca);
            }

            if ($request->filled('capacity')) {
                $query->where('pas', '>=', $request->capacity);
            }
            $vehiculos = $query->get();
        }

        return view("modules.busquedareserva.index", compact('vehiculos'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
}
