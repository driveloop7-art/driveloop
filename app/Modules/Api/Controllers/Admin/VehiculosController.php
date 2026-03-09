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
        // 1. Eloquent ORM: Le pedimos a la base de datos TODOS los usuarios
        // Nota: En un proyecto real gigante usaríamos paginación (paginate), 
        // pero para empezar, all() está perfecto.
        $vehiculos = Vehiculo::all();
        $vehiculosHechos = [];
        foreach ($vehiculos as $vehiculo) {
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
                'precio_renta' => $vehiculo->prerent,
                'disponible' => $vehiculo->disp,
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