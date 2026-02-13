<?php

namespace App\Modules\GestionUsuario\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MER\DocumentoUsuario;
use App\Models\MER\User;
use App\Notifications\DocumentoRevisado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ValidacionDocumentosController extends Controller
{
    /**
     * Muestra la lista de usuarios que tienen documentos pendientes por revisar.
     */
    public function index()
    {
        // 1. Obtener IDs de usuarios que tengan AL MENOS un documento en estado 'PENDIENTE'
        // Filtramos por tipos de documento relevantes: Identidad (1,3) y Licencia (2)
        $userIds = DocumentoUsuario::whereIn('idtipdocusu', [1, 2, 3])
            ->where('estado', 'PENDIENTE')
            ->distinct()
            ->pluck('codusu');

        // 2. Traer los usuarios con sus documentos
        $users = User::whereIn('id', $userIds)
            ->with(['documentos_usuarios' => function ($query) {
                // Solo nos interesa traer los documentos de identidad y licencia
                $query->whereIn('idtipdocusu', [1, 2, 3]);
            }])
            ->paginate(10);

        return view('modules.GestionUsuario.soporte.index', compact('users'));
    }

    /**
     * Muestra el detalle de un usuario para revisar sus documentos.
     */
    public function show($id)
    {
        $user = User::with('documentos_usuarios')->findOrFail($id);

        // Separar documentos para facilitar la vista
        $docIdentidad = $user->documentos_usuarios->whereIn('idtipdocusu', [1, 3])->first();
        $docLicencia  = $user->documentos_usuarios->where('idtipdocusu', 2)->first();

        // Verificar si hay algo pendiente
        $pendienteIdentidad = $docIdentidad && $docIdentidad->estado === 'PENDIENTE';
        $pendienteLicencia  = $docLicencia && $docLicencia->estado === 'PENDIENTE';

        return view('modules.GestionUsuario.soporte.show', compact('user', 'docIdentidad', 'docLicencia', 'pendienteIdentidad', 'pendienteLicencia'));
    }

    /**
     * Aprueba un documento específico.
     */
    public function approve($id)
    {
        $documento = DocumentoUsuario::findOrFail($id);

        if ($documento->estado !== 'PENDIENTE') {
            return back()->with('error', 'El documento no está en estado pendiente.');
        }

        $documento->estado = 'APROBADO';
        $documento->mensaje_rechazo = null; // Limpiar mensaje si existía
        $documento->save();

        // Enviar notificación al usuario
        $user = User::find($documento->codusu);
        if ($user) {
            $user->notify(new DocumentoRevisado($documento));
        }

        return back()->with('success', 'Documento aprobado correctamente.');
    }

    /**
     * Rechaza un documento específico con un motivo.
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'mensaje_rechazo' => 'required|string|max:255',
        ]);

        $documento = DocumentoUsuario::findOrFail($id);

        if ($documento->estado !== 'PENDIENTE') {
            return back()->with('error', 'El documento no está en estado pendiente.');
        }

        $documento->estado = 'RECHAZADO';
        $documento->mensaje_rechazo = $request->mensaje_rechazo;
        $documento->save();

        // Enviar notificación al usuario
        $user = User::find($documento->codusu);
        if ($user) {
            $user->notify(new DocumentoRevisado($documento, $request->mensaje_rechazo));
        }

        return back()->with('success', 'Documento rechazado correctamente.');
    }
}
