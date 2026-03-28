<?php

namespace App\Modules\BusquedaReserva\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\MER\Vehiculo;
use App\Models\MER\Reserva;

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

            // Se modifica la consulta para incluir el combustible del vehiculo
            $query = Vehiculo::with(['marca', 'linea', 'ciudad', 'fotos', 'combustible'])
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
     * Guarda un nuevo registro de reserva en la base de datos.
     * 
     * Este método valida las fechas de recogida y devolución, asegura que el vehículo existe,
     * calcula el costo total basado en los días de alquiler y crea el registro con
     * estado "Pendiente" antes de redirigir al usuario.
     */
    public function store(Request $request)
    {
        // 1. Validar los datos de entrada del formulario
        $request->validate([
            'codveh' => 'required|exists:vehiculos,cod',
            'pickup_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after_or_equal:pickup_date',
        ]);

        try {
            // Iniciar transacción de base de datos para asegurar integridad
            DB::beginTransaction();

            // 2. Obtener la información del vehículo (para el precio por día)
            $vehiculo = Vehiculo::findOrFail($request->codveh);

            // 3. Calcular la duración de la reserva en días
            $fecini = Carbon::parse($request->pickup_date);
            $fecfin = Carbon::parse($request->return_date);
            
            // Si las fechas son iguales, se cuenta como 1 día mínimo
            $dias = $fecini->diffInDays($fecfin) ?: 1; 

            // 4. Calcular el valor total (Días * Precio de Renta del vehículo)
            $valorTotal = $dias * $vehiculo->prerent;

            // 5. Crear el registro de la reserva
            $reserva = Reserva::create([
                'fecrea' => Carbon::now(),       // Fecha de creación (ahora)
                'fecini' => $fecini,             // Fecha de inicio de reserva
                'fecfin' => $fecfin,             // Fecha de fin de reserva
                'val' => $valorTotal,            // Valor calculado total
                'codusu' => Auth::id(),          // ID del usuario autenticado
                'codveh' => $request->codveh,    // ID del vehículo reservado
                'codestres' => 1,                // Estado ID 1: "Pendiente"
            ]);

            // Confirmar los cambios en la base de datos
            DB::commit();

            // Redirigir con mensaje de éxito mostrando el valor estimado
            return redirect()->route('busqueda.reserva')
                ->with('success', 'Reserva iniciada correctamente. Valor estimado: $' . number_format($valorTotal, 2));

        } catch (\Exception $e) {
            // En caso de error, revertir cualquier cambio en la BD
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Ocurrió un error al procesar la reserva: ' . $e->getMessage())
                ->withInput();
        }
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
