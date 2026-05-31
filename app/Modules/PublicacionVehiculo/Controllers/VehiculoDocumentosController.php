<?php

namespace App\Modules\PublicacionVehiculo\Controllers;

use App\Http\Controllers\Controller;

use App\Models\MER\Vehiculo;
use App\Models\MER\DocumentoVehiculo;
use App\Models\MER\FotoVehiculo;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class VehiculoDocumentosController extends Controller
{
    public function create(int $codveh)
    {
        $vehiculo = Vehiculo::where('user_id', Auth::id())
            ->where('cod', $codveh)
            ->firstOrFail();

        return view('modules.PublicacionVehiculo.documentVehic', compact('vehiculo'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'placa' => ['required', 'string', 'max:10'],
            'codveh' => ['required', 'integer'],

            'documentos' => ['required', 'array', 'size:3'],
            'documentos.*.idtipdoc' => ['required', 'integer', 'in:1,2,3'],

            'documentos.*.archivo' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],

            'fotos' => ['nullable', 'array', 'max:10'],
            'fotos.*' => ['image', 'max:6144'],
        ]);


        $placa = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $request->placa));

        $codveh = (int) $request->codveh;

        if (DocumentoVehiculo::where('numdoc', $placa)->exists()) {
            return back()->with(['message' => 'La placa ingresada ya se encuentra en uso.']);
        }

        $docsDir  = "vehiculos/{$placa}/documentos";
        $fotosDir = "vehiculos/{$placa}/fotos";

        DB::transaction(function () use ($request, $placa, $codveh, $docsDir, $fotosDir) {

    
            foreach ($request->documentos as $doc) {

                $idtipdoc = (int) $doc['idtipdoc'];
                $file     = $doc['archivo'];
                $ext      = strtolower($file->getClientOriginalExtension() ?: 'pdf');

                $map = [
                    1 => 'tarjeta_propiedad',
                    2 => 'soat',
                    3 => 'tecnomecanica',
                ];

                $base   = $map[$idtipdoc] ?? ('documento_' . $idtipdoc);
                $nombre = "{$base}.{$ext}";

                $path = $file->storeAs($docsDir, $nombre, 'public');

                DocumentoVehiculo::create([
                    'idtipdocveh' => $idtipdoc,
                    'numdoc'      => $placa,
                    'empexp'      => '',
                    'descdoc'     => $path,
                    'codveh'      => $codveh,
                ]);
            }



            if ($request->hasFile('fotos')) {
                foreach ($request->file('fotos') as $i => $foto) {
                    $ext = strtolower($foto->getClientOriginalExtension() ?: 'jpg');
                    $nombre = $placa . '_' . str_pad($i + 1, 2, '0', STR_PAD_LEFT) . '.' . $ext;

                    $imgSize = @getimagesize($foto->getRealPath());
                    $dim = $imgSize ? ($imgSize[0] . 'x' . $imgSize[1]) : '';

                    $mim = $foto->getMimeType() ?? '';
                    $pes = (int) $foto->getSize();

                    $path = null;

                    if ($imgSize && ($imgSize[0] > 800 || $imgSize[1] > 600)) {
                        $tmpResized = $this->resizeImageToFit($foto->getRealPath(), $ext, 800, 600);

                        if ($tmpResized) {
                            $path = Storage::disk('public')->putFileAs($fotosDir, new File($tmpResized), $nombre);
                            @unlink($tmpResized);
                        }
                    }

                    if ($path === null) {
                        $path = $foto->storeAs($fotosDir, $nombre, 'public');
                    }

                    FotoVehiculo::create([
                        'nom'    => $nombre,
                        'ruta'   => $path,
                        'dim'    => $dim,
                        'mim'    => $mim,
                        'pes'    => $pes,
                        'codveh' => $codveh,
                    ]);
                }
            }
        });

        return back()->with('docs_saved', true);
        
    }

    private function resizeImageToFit(string $filePath, string $extension, int $maxWidth, int $maxHeight): ?string
    {
        $imgSize = @getimagesize($filePath);
        if (! $imgSize) {
            return null;
        }

        [$width, $height] = $imgSize;
        if ($width <= $maxWidth && $height <= $maxHeight) {
            return null;
        }

        $source = @imagecreatefromstring(file_get_contents($filePath));
        if (! $source) {
            return null;
        }

        $ratio = min($maxWidth / $width, $maxHeight / $height);
        $newWidth = max(1, (int) round($width * $ratio));
        $newHeight = max(1, (int) round($height * $ratio));

        $resized = imagecreatetruecolor($newWidth, $newHeight);
        imagealphablending($resized, false);
        imagesavealpha($resized, true);
        imagecopyresampled($resized, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        $tmpPath = tempnam(sys_get_temp_dir(), 'veh_');
        if ($tmpPath === false) {
            imagedestroy($source);
            imagedestroy($resized);
            return null;
        }

        switch (strtolower($extension)) {
            case 'png':
                imagepng($resized, $tmpPath, 6);
                break;
            case 'gif':
                imagegif($resized, $tmpPath);
                break;
            case 'webp':
                imagewebp($resized, $tmpPath, 80);
                break;
            default:
                imagejpeg($resized, $tmpPath, 90);
                break;
        }

        imagedestroy($source);
        imagedestroy($resized);

        return $tmpPath;
    }
}
