<?php

namespace App\Modules\Api\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MER\DocumentoUsuario;

class DocumentController extends Controller
{
    /**
     * Sube y registra documentos (Anverso y Reverso).
     */
    public function upload(Request $request)
    {
        // 1. Validar los datos que envió la app móvil
        $request->validate([
            'idtipdocusu' => 'required|integer|in:1,2,3', // 1=Cédula, 2=Licencia, 3=Pasaporte
            'num'         => 'required|string|max:50',
            'anverso'     => 'required|image|mimes:jpeg,png,jpg|max:5120', // Foto de max 5MB
            'reverso'     => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        try {
            // El middleware auth:sanctum nos da automáticamente el usuario logueado
            $user = $request->user(); 
            
            // 2. Carpeta donde físicamente vivirán las fotos (ej: documentos/25)
            $carpetaDestino = 'documentos/' . $user->id;
            
            $anversoPath = $request->file('anverso')->store($carpetaDestino, 'public');
            $reversoPath = $request->file('reverso')->store($carpetaDestino, 'public');

            // 3. Crear el registro en la base de datos o actualizarlo si ya existía
            $documento = DocumentoUsuario::updateOrCreate(
                [
                    // Condición de búsqueda
                    'codusu'      => $user->id,
                    'idtipdocusu' => $request->idtipdocusu,
                ],
                [
                    // Datos a actualizar / crear
                    'num'             => $request->num,
                    'url_anverso'     => $anversoPath,
                    'url_reverso'     => $reversoPath,
                    'estado'          => 'PENDIENTE', // Pasa a revisión administrativa
                    'mensaje_rechazo' => null
                ]
            );

            // 4. Retornar éxito a la app móvil
            return response()->json([
                'status'  => 'Success',
                'message' => 'Documentos subidos y en espera de validación administrativa.',
                'data'    => $documento
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'Error',
                'message' => 'No pudimos guardar los documentos.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Entregamos a la app móvil una lista de los documentos que el usuario ya subió
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        $documentos = DocumentoUsuario::where('codusu', $user->id)
            ->with('tipo_doc_usuario') // Trae los datos de la otra tabla (como el nombre "Cédula")
            ->get();

        return response()->json([
            'status'  => 'Success',
            'message' => 'Documentos recuperados con éxito',
            'data'    => $documentos
        ], 200);
    }

    /**
     * Retorna los tipos de documentos disponibles (Cédula, Pasaporte, etc)
     */
    public function getDocumentTypes()
    {
        $tipos = \App\Models\MER\TipoDocUsuario::all();
        return response()->json([
            'status' => 'Success',
            'data'   => $tipos
        ], 200);
    }
}
