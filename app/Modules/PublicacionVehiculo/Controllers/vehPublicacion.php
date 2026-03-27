<?php

namespace App\Modules\PublicacionVehiculo\Controllers;

use Illuminate\Http\Request;
use App\Models\MER\Clase;
use App\Models\MER\Combustible;
use App\Models\MER\Marca;
use App\Modules\PublicacionVehiculo\Models\Accesorio;
use App\Models\MER\Departamento;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\MER\Vehiculo;


class vehPublicacion extends Controller
{
    public function index()
    {
        $vehiculos = Vehiculo::query()
            ->where('user_id', Auth::id())
            ->with(['fotos' => fn($q) => $q->orderBy('cod')])
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

    public function edit(int $cod)
    {
        $vehiculo = Vehiculo::with(['marca', 'linea', 'clase', 'ciudad'])
            ->where('cod', $cod)
            ->where('user_id', Auth::id()) 
            ->firstOrFail();


        return view('modules.PublicacionVehiculo.editVeh', [
            'vehiculo' => $vehiculo,
            'vehiculoClase' => Clase::all(),
            'vehiculoMarca' => Marca::all(),
            'vehiculoAccesorios' => Accesorio::all(),
            'vehiculoCombustible' => Combustible::all(),
            'deptoVehiculo' => Departamento::all(),
        ]);
    }

    public function update(Request $request, int $cod)
    {
        $vehiculo = Vehiculo::where('cod', $cod)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $data = $request->validate([
            'vin' => ['required', 'string'],
            'mod' => ['required', 'integer', 'between:1900,' . (date('Y') + 1)],
            'col' => ['required', 'string', 'max:30'],
            'pas' => ['required', 'integer', 'min:1', 'max:99'],
            'cil' => ['required', 'integer', 'min:50', 'max:10000'],
            'codpol' => ['required', 'integer', 'exists:polizas_vehiculo,cod'],
            'codmar' => ['required', 'integer'],
            'codlin' => ['required', 'integer'],
            'codcla' => ['required', 'integer'],
            'codcom' => ['required', 'integer'],
            'codciu' => ['required', 'integer', 'exists:ciudades,cod'],
            'accesorios' => ['nullable', 'array'],
            'accesorios.*' => ['integer', 'exists:accesorios,id'],
            'prerent' => ['required', 'numeric', 'min:0'],
        ]);

        DB::transaction(function () use ($vehiculo, $data) {
            $vehiculo->update([
                'vin' => $data['vin'],
                'mod' => $data['mod'],
                'col' => $data['col'],
                'pas' => $data['pas'],
                'cil' => $data['cil'],
                'codpol' => $data['codpol'],
                'codmar' => $data['codmar'],
                'codlin' => $data['codlin'],
                'codcla' => $data['codcla'],
                'codcom' => $data['codcom'],
                'codciu' => $data['codciu'],
                'prerent' => $data['prerent'],
            ]);

            $vehiculo->accesorios()->sync($data['accesorios'] ?? []);
        });
        // modificacion en ruta para redireccionamiento al dashboard una ves finalizada la edicion del vehículo
        return redirect()
            ->route('dashboard')
            ->with('success', 'Vehículo actualizado correctamente.');
    }

    public function documentosCreate(int $codveh)
    {
        $vehiculo = Vehiculo::with('documentos_vehiculos')
            ->where('cod', $codveh)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('vehiculos.documentos.create', compact('vehiculo'));
    }

    public function documentosStore(Request $request, int $codveh)
    {
        $vehiculo = Vehiculo::where('cod', $codveh)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $data = $request->validate([
            'tarjeta' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'soat'    => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'tecno'   => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        return redirect()->route('vehiculo-ver')->with('success', 'Documentos actualizados.');
    }
}
