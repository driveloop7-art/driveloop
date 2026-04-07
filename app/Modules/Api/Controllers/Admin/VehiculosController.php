<?php

namespace App\Modules\Api\Controllers\Admin;
use App\Models\MER\Vehiculo; // Importamos el modelo que habla con la tabla de vehiculos
use App\Http\Controllers\Controller;

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
}