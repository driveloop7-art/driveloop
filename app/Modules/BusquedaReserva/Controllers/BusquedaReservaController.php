<?php

namespace App\Modules\BusquedaReserva\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use App\Models\MER\Vehiculo;

class BusquedaReservaController extends Controller
{
 

    public function index(Request $request)
    {
        $vehiculos = [];
        

        if ($request->isMethod('post')) {

            $validator = Validator::make($request->all(), [
                'pickup_date' => 'required|date|after_or_equal:today',
                'return_date' => 'required|date|after_or_equal:pickup_date',
            ], [
                'pickup_date.after_or_equal' => 'La fecha de recogida no puede ser en el pasado.'
            ]);

            if ($validator->fails()) {
                return redirect('/')
                    ->withErrors($validator)
                    ->withInput();
            }

            $query = Vehiculo::query()->with(['marca', 'linea', 'ciudad', 'fotos']);


            if ($request->filled('marca')) {
                $query->where('codmar', $request->marca);
            }

            if ($request->filled('capacity')) {
                $query->where('pas', '>=', (int)$request->capacity);
            }

            
            if ($request->filled('price_range')) {
                $range = $request->price_range;

                if (str_ends_with($range, '+')) {
                    $min = (int) rtrim($range, '+');
                    $query->where('prerent', '>=', $min);
                } else {
                    [$min, $max] = array_map('intval', explode('-', $range));
                    $query->whereBetween('prerent', [$min, $max]);
                }
            }

            $vehiculos = $query->orderByDesc('cod')->get();
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
