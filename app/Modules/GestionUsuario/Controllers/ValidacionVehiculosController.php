<?php

namespace App\Modules\GestionUsuario\Controllers;

use App\Models\MER\FotoVehiculo;
use App\Http\Controllers\Controller;
use App\Models\MER\DocumentoVehiculo;
use App\Models\MER\Vehiculo;
use Illuminate\Http\Request;

class ValidacionVehiculosController extends Controller
{
    /**
     * Muestra la lista de vehículos que tienen documentos pendientes por revisar.
     */
    public function index()
    {
        // Obtener IDs de vehículos con al menos un documento PENDIENTE
        $vehIds = DocumentoVehiculo::whereIn('idtipdocveh', [1, 2, 3])
            ->where('estado', 'PENDIENTE')
            ->distinct()
            ->pluck('codveh');

        $vehiculos = Vehiculo::whereIn('cod', $vehIds)
            ->with(['marca', 'linea', 'documentos_vehiculos' => function ($query) {
                $query->whereIn('idtipdocveh', [1, 2, 3]);
            }])
            ->paginate(10);

        return view('modules.GestionUsuario.soporte.index_vehiculos', compact('vehiculos'));
    }

    /**
     * Muestra el detalle de un vehículo para revisar sus documentos.
     */
    public function show($cod)
    {
        $vehiculo = Vehiculo::with(['marca', 'linea', 'documentos_vehiculos', 'fotos'])->findOrFail($cod);

        // Separar documentos
        $docTarjeta = $vehiculo->documentos_vehiculos->where('idtipdocveh', 1)->first();
        $docSoat    = $vehiculo->documentos_vehiculos->where('idtipdocveh', 2)->first();
        $docTecno   = $vehiculo->documentos_vehiculos->where('idtipdocveh', 3)->first();

        return view('modules.GestionUsuario.soporte.show_vehiculo', compact(
            'vehiculo', 
            'docTarjeta', 
            'docSoat', 
            'docTecno'
        ));
    }

    /**
     * Aprueba un documento de vehículo.
     */
    public function approve($id)
    {
        $documento = DocumentoVehiculo::findOrFail($id);

        if ($documento->estado !== 'PENDIENTE') {
            return back()->with('error', 'El documento no está en estado pendiente.');
        }

        $documento->estado = 'APROBADO';
        $documento->mensaje_rechazo = null;
        $documento->save();

        return back()->with('success', 'Documento del vehículo aprobado correctamente.');
    }

    /**
     * Rechaza un documento de vehículo.
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'mensaje_rechazo' => 'required|string|max:255',
        ]);

        $documento = DocumentoVehiculo::findOrFail($id);

        if ($documento->estado !== 'PENDIENTE') {
            return back()->with('error', 'El documento no está en estado pendiente.');
        }

        $documento->estado = 'RECHAZADO';
        $documento->mensaje_rechazo = $request->mensaje_rechazo;
        $documento->save();

        return back()->with('success', 'Documento del vehículo rechazado correctamente.');
    }
}
