<?php

namespace App\Modules\GestionUsuario\Controllers;

use App\Models\MER\FotoVehiculo;
use App\Http\Controllers\Controller;
use App\Models\MER\DocumentoVehiculo;
use App\Models\MER\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function approve($id)
    {
        return DB::transaction(function () use ($id) {

            $documento = DocumentoVehiculo::findOrFail($id);

            if ($documento->estado !== 'PENDIENTE') {
                return back()->with('error', 'El documento no está en estado pendiente.');
            }

            // 1) Aprobar documento
            $documento->update([
                'estado' => 'APROBADO',
                'mensaje_rechazo' => null,
            ]);

            $codveh = $documento->codveh;

            $aprobadosPorTipo = DocumentoVehiculo::where('codveh', $codveh)
                ->whereIn('idtipdocveh', [1, 2, 3])
                ->where('estado', 'APROBADO')
                ->distinct('idtipdocveh')
                ->count('idtipdocveh');

            $vehiculo = Vehiculo::where('cod', $codveh)->firstOrFail();

            if ($aprobadosPorTipo === 3) {

                $vehiculo->update(['disp' => 1]);

                return redirect()
                    ->route('soporte.vehiculos.index')
                    ->with('success', 'Vehículo completamente aprobado. Ahora está disponible.');
            }

            $vehiculo->update(['disp' => 0]);

            return redirect()
                ->route('soporte.vehiculos.show', $codveh)
                ->with('success', 'Documento aprobado. Aún faltan documentos por aprobar.');
        });
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'mensaje_rechazo' => 'required|string|max:255',
        ]);

        return DB::transaction(function () use ($request, $id) {

            $documento = DocumentoVehiculo::findOrFail($id);

            if ($documento->estado !== 'PENDIENTE') {
                return back()->with('error', 'El documento no está en estado pendiente.');
            }

            // 1) Rechazar documento
            $documento->update([
                'estado' => 'RECHAZADO',
                'mensaje_rechazo' => $request->mensaje_rechazo,
            ]);

            Vehiculo::where('cod', $documento->codveh)->update(['disp' => 0]);

            return back()->with('success', 'Documento rechazado.');
        });
    }
}
