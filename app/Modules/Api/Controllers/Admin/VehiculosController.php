<?php

namespace App\Modules\Api\Controllers\Admin;
use App\Models\MER\Vehiculo; // Importamos el modelo que habla con la tabla de vehiculos
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VehiculosController extends Controller
{
    /**
     * Devuelve la lista de todos los vehiculos registrados.
     */
    public function index()
    {

        $vehiculos = Vehiculo::all();
        $vehiculosHechos = [];
        foreach ($vehiculos as $vehiculo) {

            // Replicando la lógica de la imagen de la vista web:
            $ruta = $vehiculo->fotos_vehiculos->first()?->ruta;
            $fotoUrl = asset('img/no-image.jpg'); // Fallback por defecto

            if ($ruta) {
                if (str_starts_with($ruta, 'http')) {
                    $fotoUrl = $ruta;
                } else {
                    $ruta = ltrim($ruta, '/');
                    if (!str_starts_with($ruta, 'vehiculos/')) {
                        $ruta = 'vehiculos/' . $ruta;
                    }
                    $fotoUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($ruta);
                }
            }

            $vehiculosHechos[] = [
                'cod' => $vehiculo->cod,
                'vin' => $vehiculo->vin,
                'marca' => $vehiculo->marca->des,
                'linea' => $vehiculo->linea->des,
                'modelo' => $vehiculo->mod,
                'color' => $vehiculo->col,
                'pasajeros' => $vehiculo->pas,
                'cilindraje' => $vehiculo->cil,
                'poliza' => $vehiculo->codpol,
                'combustible' => $vehiculo->codcom,
                'ciudad' => $vehiculo->codciu,
                'precio_renta' => number_format((float) ($vehiculo->prerent ?? 0), 0, ',', '.'),
                'precio_renta_crudo' => $vehiculo->prerent,
                'disponibilidad' => $vehiculo->disp,
                'imagen' => $fotoUrl,
            ];
        }

        // 2. Armamos la respuesta en el formato JSON que nuestra app de Python espera
        return response()->json([
            'status' => 'Success',
            'message' => 'Vehiculos obtenidos correctamente',
            'data' => $vehiculosHechos
        ], 200);
    }

    public function index_desktop()
    {
        $vehiculos = Vehiculo::all();
        $vehiculosDTO = $vehiculos->map(fn($vehiculo) => [
            'usuario_nombre' => $vehiculo->user->nom,
            'usuario_apellido' => $vehiculo->user->ape,
            'cod' => $vehiculo->cod,
            'marca' => $vehiculo->marca->des,
            'linea' => $vehiculo->linea->des,
            'clase' => $vehiculo->clase->des,
            'ciudad' => $vehiculo->ciudad->des,
            'mod' => $vehiculo->mod,
            'col' => $vehiculo->col,
            'pas' => $vehiculo->pas,
            'prerent' => $vehiculo->prerent,
            'vin' => $vehiculo->vin,
            'cil' => $vehiculo->cil,
            'combustible' => $vehiculo->combustible->des,
            'disp' => $vehiculo->disp,
            'total_reservas' => $vehiculo->reservas->count(),
            'reservas_activas' => $vehiculo->reservas()->whereIn('codestres', [1, 2])->count(),
        ]);
        return response()->json([
            'status' => 'Success',
            'message' => 'Vehiculos obtenidos correctamente',
            'data' => $vehiculosDTO
        ], 200);
    }

    public function veh_reservas_desktop($id)
    {
        $vehiculo = Vehiculo::find($id);
        if (!$vehiculo) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Vehículo no encontrado',
                'data' => null
            ], 404);
        }

        $reservasDTO = $vehiculo->reservas->map(fn($reserva) => [
            'cod' => $reserva->cod,
            'usuario_nombre' => $reserva->user->nom,
            'usuario_apellido' => $reserva->user->ape,
            'email' => $reserva->user->email,
            'tel' => $reserva->user->tel,
            'fecrea' => $reserva->fecrea,
            'fecini' => $reserva->fecini,
            'fecfin' => $reserva->fecfin,
            'val' => $reserva->val,
            'estado' => $reserva->estado_reserva->des,
            'confirmado_propietario' => true, // REVISAR POR QUE NO SÉ A QUÉ SE REFIERE
        ]);

        return response()->json([
            'status' => 'Success',
            'message' => 'Reservas del vehículo obtenidas correctamente',
            'data' => $reservasDTO
        ], 200);
    }

    public function veh_update_desktop($id, Request $request)
    {
        $vehiculo = Vehiculo::find($id);
        if (!$vehiculo) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Vehículo no encontrado',
                'data' => null
            ], 404);
        }

        $validated = $request->validate([
            'mod' => 'nullable|integer',
            'col' => 'nullable|string|max:255',
            'pas' => 'nullable|integer',
            'prerent' => 'nullable|integer',
            'disp' => 'nullable|boolean',
        ]);

        $vehiculo->update($validated);

        return response()->json([
            'status' => 'Success',
            'message' => 'Disponibilidad del vehículo actualizada correctamente',
            'data' => []
        ], 200);
    }

    public function veh_delete_desktop($id)
    {
        $vehiculo = Vehiculo::find($id);
        if (!$vehiculo) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Vehículo no encontrado',
                'data' => null
            ], 404);
        }

        $tieneReservasActivas = $vehiculo->reservas()->count();
        if ($tieneReservasActivas > 0) {
            return response()->json([
                'status' => 'Error',
                'message' => 'No se puede eliminar el vehículo porque tiene reserva(s) asociadas',
                'data' => null
            ], 400);
        }

        $tieneDocumentos = $vehiculo->documentos_vehiculos()->count();
        if ($tieneDocumentos > 0) {
            return response()->json([
                'status' => 'Error',
                'message' => 'No se puede eliminar el vehículo porque tiene documento(s) asociados',
                'data' => null
            ], 400);
        }

        $vehiculo->delete();
        return response()->json([
            'status' => 'Success',
            'message' => 'Vehículo eliminado correctamente',
            'data' => null
        ], 200);
    }
}