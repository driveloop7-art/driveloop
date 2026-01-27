<?php
namespace App\Modules\GestionUsuario\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\MER\DocumentoUsuario;
use App\Models\MER\TipoDocUsuario;
use Illuminate\Support\Facades\Storage;
class DocumentoUsuarioController extends Controller
{
    // Mostrar formulario y estado de documentos
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Cargar documentos del usuario
        $documentos = $user->documentos_usuarios;
        $documentosTipo = TipoDocUsuario::whereIn('id', [1, 3, 4])->get();
        // Buscar documentos específicos por tipo
        // 1: Identidad, 2: Licencia, 3: Pasaporte
        $docIdentidad = $documentos->whereIn('idtipdocusu', [1, 3])->first();
        ;
        $docLicencia = $documentos->where('idtipdocusu', 2)->first();
        return view('modules.GestionUsuario.documentos.index', compact('docIdentidad', 'docLicencia', 'documentosTipo'));
    }
    // Procesar la subida de documentos
    public function store(Request $request)
    {
        $user = Auth::user();
        // Reglas de validación base
        $rules = [
            'documento_tipo' => 'required|in:1,2,3',
            'num' => 'required|string|max:45',
            'archivo_anverso' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ];
        // Validar reverso: Obligatorio para Cédula (1) y Licencia (2). Opcional para Pasaporte (3).
        if (in_array($request->documento_tipo, ['1', '2'])) {
            $rules['archivo_reverso'] = 'required|file|mimes:jpg,jpeg,png,pdf|max:5120';
        } else {
            $rules['archivo_reverso'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120';
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $numTipoDoc = $request->input('documento_tipo');
        //Encontrar el tipo de documento usando el modelo
        $tipoDoc = TipoDocUsuario::find($numTipoDoc);
        $numDoc = $request->input('num');

        // 1. Procesar Anverso
        $archivoAnverso = $request->file('archivo_anverso');
        //Creacion de ruta de ubicacion de archivo anverso
        $pathAnverso = $archivoAnverso->storeAs(
            "documentos/{$user->id}/{$tipoDoc->nom}",
            time() . "_anverso_{$numTipoDoc}." . $archivoAnverso->getClientOriginalExtension(),
            'public'
        );

        // 2. Procesar Reverso (si existe)
        $pathReverso = null;
        if ($request->hasFile('archivo_reverso')) {
            $archivoReverso = $request->file('archivo_reverso');
            //Creacion de ruta de ubicacion de archivo reverso
            $pathReverso = $archivoReverso->storeAs(
                "documentos/{$user->id}/{$tipoDoc->nom}",
                time() . "_reverso_{$numTipoDoc}." . $archivoReverso->getClientOriginalExtension(),
                'public'
            );
        }
        // 3. Eliminar archivos antiguos si existen (evitar acumulación de basura)
        $documentoExistente = DocumentoUsuario::where('codusu', $user->id)
            ->where('idtipdocusu', $numTipoDoc)
            ->first();

        if ($documentoExistente) {
            // Borrar archivo anverso anterior si existe
            if ($documentoExistente->url_anverso && Storage::disk('public')->exists($documentoExistente->url_anverso)) {
                Storage::disk('public')->delete($documentoExistente->url_anverso);
            }
            // Borrar archivo reverso anterior si existe
            if ($documentoExistente->url_reverso && Storage::disk('public')->exists($documentoExistente->url_reverso)) {
                Storage::disk('public')->delete($documentoExistente->url_reverso);
            }
        }

        // 4. Guardar en Base de Datos
        DocumentoUsuario::updateOrCreate(
            [
                'codusu' => $user->id,
                'idtipdocusu' => $numTipoDoc
            ],
            [
                'num' => $numDoc,
                'url_anverso' => $pathAnverso,  // Nombre actualizado (url_archivo)
                'url_reverso' => $pathReverso,  // Nuevo campo
                'estado' => 'PENDIENTE',
                'mensaje_rechazo' => null
            ]
        );
        return back()->with('success', 'Documentos subidos correctamente. Están en proceso de revisión.');
    }
}