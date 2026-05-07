<?php

namespace App\Modules\GestionUsuario\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MER\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservaVehiculoController extends Controller
{
    public function finalizar(Request $request, $cod)
    {
        $request->validate([
            'observacion_recepcion' => 'nullable|string|max:1000',
            'recibido_buen_estado' => 'nullable|in:0,1',
        ]);

        DB::beginTransaction();

        try {
            $reserva = Reserva::with('vehiculo')->lockForUpdate()->findOrFail($cod);

            if (!$reserva->vehiculo || $reserva->vehiculo->user_id !== auth()->id()) {
                DB::rollBack();
                abort(403, 'No tienes permiso para finalizar esta reserva.');
            }

            if ((int) $reserva->codestres === 3) {
                DB::commit();

                return redirect()
                    ->route('dashboard')
                    ->with('message', 'La reserva ya está finalizada.');
            }

            $reserva->codestres = 3;
            $reserva->fecha_cierre_real = now();
            $reserva->confirmado_propietario = true;
            $reserva->observacion_recepcion = $request->observacion_recepcion;
            $reserva->recibido_buen_estado = $request->input('recibido_buen_estado');
            $reserva->save();

            if ($reserva->vehiculo) {
                $tieneOtrasReservasActivas = Reserva::where('codveh', $reserva->codveh)
                    ->where('cod', '!=', $reserva->cod)
                    ->where('codestres', '!=', 3)
                    ->lockForUpdate()
                    ->exists();

                $reserva->vehiculo->disp = !$tieneOtrasReservasActivas;
                $reserva->vehiculo->save();
            }

            DB::commit();

            return redirect()
                ->route('dashboard')
                ->with('message', 'La reserva fue finalizada correctamente.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()
                ->route('dashboard')
                ->with('error', 'No fue posible finalizar la reserva: ' . $e->getMessage());
        }
    }
}