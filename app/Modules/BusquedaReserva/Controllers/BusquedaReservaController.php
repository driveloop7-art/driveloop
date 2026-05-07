<?php

namespace App\Modules\BusquedaReserva\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
        $vehiculos = collect();
        $pickup_date = null;
        $return_date = null;

        if ($request->isMethod('post')) {

            $validator = Validator::make($request->all(), [
                'pickup_date' => 'required|date|after_or_equal:today',
                'return_date' => 'required|date|after_or_equal:pickup_date',
                'codveh' => 'nullable|exists:vehiculos,cod',
            ], [
                'pickup_date.after_or_equal' => 'La fecha de recogida no puede ser en el pasado.',
                'return_date.after_or_equal' => 'La fecha de entrega no puede ser menor a la de recogida.',
            ]);

            if ($validator->fails()) {
                return redirect('/')
                    ->withErrors($validator)
                    ->withInput();
            }

            $pickup_date = $request->pickup_date;
            $return_date = $request->return_date;

            $query = Vehiculo::with(['marca', 'linea', 'ciudad', 'fotos', 'combustible'])
                ->where('disp', 1)
                ->whereDoesntHave('reservas', function ($q) use ($pickup_date, $return_date) {
                    $q->where('codestres', '!=', 3)
                        ->where(function ($sub) use ($pickup_date, $return_date) {
                            $sub->where('fecini', '<', $return_date)
                                ->where('fecfin', '>', $pickup_date);
                        });
                });

            // if ($request->filled('codveh')) {
            //     $query->where('cod', $request->codveh);
            // } else {
            //     if ($request->filled('marca')) {
            //         $query->where('codmar', (int) $request->marca);
            //     }

            //     $capacity = $request->input('capacity');
            //     if ($capacity !== null && $capacity !== '' && (int) $capacity !== 4) {
            //         $query->where('pas', '>=', (int) $capacity);
            //     }

            //     if ($request->filled('price_range')) {
            //         $range = trim($request->price_range);

            //         if (str_ends_with($range, '+')) {
            //             $min = (int) rtrim($range, '+');
            //             $query->where('prerent', '>=', $min);
            //         } else {
            //             [$min, $max] = array_map('intval', explode('-', $range));
            //             $query->whereBetween('prerent', [$min, $max]);
            //         }
            //     }
            // }

            if ($request->filled('codveh')) {
                $query->where('cod', $request->codveh);
            } else {
                if ($request->filled('marca')) {
                    $query->where('codmar', (int) $request->marca);
                }

                $capacity = $request->input('capacity');
                if ($capacity !== null && $capacity !== '' && (int) $capacity !== 4) {
                    $query->where('pas', '>=', (int) $capacity);
                }

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
            }

            $vehiculos = $query->orderByDesc('cod')->get();
        }

        return view('modules.BusquedaReserva.index', compact(
            'vehiculos',
            'pickup_date',
            'return_date'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'codveh' => 'required|exists:vehiculos,cod',
            'pickup_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after_or_equal:pickup_date',
        ]);

        try {
            DB::beginTransaction();

            $vehiculo = Vehiculo::lockForUpdate()->findOrFail($request->codveh);

            if (!(bool) $vehiculo->disp) {
                DB::rollBack();
                return redirect()->back()
                    ->with('error', 'El vehículo ya no se encuentra disponible.')
                    ->withInput();
            }

            $fecini = Carbon::parse($request->pickup_date);
            $fecfin = Carbon::parse($request->return_date);

            // Si las fechas son iguales, se cuenta como 1 día mínimo
            $dias = $fecini->diffInDays($fecfin) ?: 1;

            $reservaActivaSolapada = Reserva::where('codveh', $vehiculo->cod)
                ->where('codestres', '!=', 3)
                ->where(function ($q) use ($fecini, $fecfin) {
                    $q->where('fecini', '<', $fecfin)
                        ->where('fecfin', '>', $fecini);
                })
                ->lockForUpdate()
                ->exists();

            if ($reservaActivaSolapada) {
                DB::rollBack();
                return redirect()->back()
                    ->with('error', 'El vehículo ya está reservado para esas fechas.')
                    ->withInput();
            }

            $dias = $fecini->diffInDays($fecfin);
            if ($dias < 1) {
                $dias = 1;
            }

            $valorTotal = $dias * $vehiculo->prerent;

            Reserva::create([
                'fecrea' => Carbon::now(),
                'fecini' => $fecini,
                'fecfin' => $fecfin,
                'val' => $valorTotal,
                'idusu' => Auth::id(),
                'codveh' => $request->codveh,
                'codestres' => 1,
            ]);

            $vehiculo->disp = 0;
            $vehiculo->save();

            DB::commit();

            return redirect()->route('busqueda.reserva')
                ->with('success', 'Reserva iniciada correctamente. Valor estimado: $' . number_format($valorTotal, 2));
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Ocurrió un error al procesar la reserva: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function create()
    {
        //
    }

    public function show()
    {
        //
    }

    public function edit()
    {
        //
    }

    public function update(Request $request)
    {
        //
    }

    public function destroy()
    {
        //
    }
}
