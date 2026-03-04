<?php

namespace App\Modules\BusquedaReserva\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use App\Models\MER\Vehiculo;

class BusquedaReservaController extends Controller
{


    // public function index(Request $request)
    // {
    //     $vehiculos = [];


    //     if ($request->isMethod('post')) {

    //         $validator = Validator::make($request->all(), [
    //             'pickup_date' => 'required|date|after_or_equal:today',
    //             'return_date' => 'required|date|after_or_equal:pickup_date',
    //         ], [
    //             'pickup_date.after_or_equal' => 'La fecha de recogida no puede ser en el pasado.'
    //         ]);

    //         if ($validator->fails()) {
    //             return redirect('/')
    //                 ->withErrors($validator)
    //                 ->withInput();
    //         }

    //         $query = Vehiculo::with(['marca', 'linea', 'ciudad', 'fotos'])
    //             ->where('disp', 1);


    //         if ($request->filled('marca')) {
    //             $query->where('codmar', $request->marca);
    //         }

    //         // Si hay pasajeros seleccionados, filtra por esa cantidad
    //         if ($request->filled('capacity')) {
    //             $query->where('pas', '>=', (int)$request->capacity);
    //         }


    //         if ($request->filled('price_range')) {
    //             $range = $request->price_range;

    //             if (str_ends_with($range, '+')) {
    //                 $min = (int) rtrim($range, '+');
    //                 $query->where('prerent', '>=', $min);
    //             } else {
    //                 [$min, $max] = array_map('intval', explode('-', $range));
    //                 $query->whereBetween('prerent', [$min, $max]);
    //             }
    //         }

    //         $vehiculos = $query->orderByDesc('cod')->get();
    //     }

    //     return view("modules.busquedareserva.index", compact('vehiculos'));
    // }
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

        $query = Vehiculo::with(['marca', 'linea', 'ciudad', 'fotos'])
            ->where('disp', 1);

        // Marca
        if ($request->filled('marca')) {
            $query->where('codmar', (int) $request->marca);
        }

        // Capacidad:
        // eSTE select siempre envía un valor (por defecto 4), entonces NO filtramos si es 4.
        // Se realiza este cambio debido a que este filtro genera un retorno erroneo en la consulta
        // de esta forma se asegura que el filtro se realize solo con los parametros del formulario
        // se deja la opcion para definir en el futuro si al formulario se la agrega la opcion de capacidad o similar
        $capacity = $request->input('capacity');
        if ($capacity !== null && $capacity !== '' && (int) $capacity !== 4) {
            $query->where('pas', '>=', (int) $capacity);
        }

        // Rango de precio
        if ($request->filled('price_range')) {
            $range = trim($request->price_range);

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
