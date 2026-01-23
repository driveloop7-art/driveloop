<?php

namespace App\Modules\PublicacionVehiculo\Controllers;

use Illuminate\Http\Request;
use App\Models\MER\Clase;
use App\Models\MER\Combustible;
use App\Models\MER\Marca;
use App\Models\MER\Accesorio;
use App\Models\MER\Departamento;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use App\Models\MER\Vehiculo;


class vehPublicacion extends Controller
{
    public function index()
    {
        $vehiculos = Vehiculo::query()
            ->where('user_id', Auth::id())
            ->with(['fotos' => fn($q) => $q->orderBy('cod')]) // trae fotos
            ->orderByDesc('cod')
            ->get();

        return view('modules.PublicacionVehiculo.index', [
            'vehiculoClase' => Clase::all(),
            'vehiculoMarca' => Marca::all(),
            'vehiculoAccesorios' => Accesorio::all(),
            'vehiculoCombustible' => Combustible::all(),
            'deptoVehiculo' => Departamento::all(),
            'vehiculos' => $vehiculos, 
        ]);
    }
}
