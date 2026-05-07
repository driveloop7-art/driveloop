<?php

namespace App\Modules\GestionUsuario\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MER\Reserva;
use App\Services\Reservas\ReservaDocumentoService;
use Illuminate\Support\Facades\Storage;

class ReservaDocumentoController extends Controller
{
    // public function descargarContrato(Reserva $reserva)
    // {
    //     abort_unless($reserva->idusu === auth()->id(), 403);

    //     $reserva->load('contrato');

    //     if (!$reserva->contrato || !$reserva->contrato->pdf_path) {
    //         abort(404, 'El contrato no ha sido generado.');
    //     }

    //     return Storage::disk('public')->download(
    //         $reserva->contrato->pdf_path,
    //         'contrato-reserva-' . $reserva->cod . '.pdf'
    //     );
    // }

    // public function descargarPoliza(Reserva $reserva)
    // {
    //     abort_unless($reserva->idusu === auth()->id(), 403);

    //     $reserva->load('polizaServicio');

    //     if (!$reserva->polizaServicio || !$reserva->polizaServicio->pdf_path) {
    //         abort(404, 'La póliza no ha sido generada.');
    //     }

    //     return Storage::disk('public')->download(
    //         $reserva->polizaServicio->pdf_path,
    //         'poliza-reserva-' . $reserva->cod . '.pdf'
    //     );
    // }

  
    public function descargarContrato(Reserva $reserva)
    {
        abort_unless($reserva->idusu === auth()->id(), 403);

        $reserva->load('contrato');

        if (!$reserva->contrato || !$reserva->contrato->pdf_path) {
            abort(404, 'El contrato no ha sido generado.');
        }

        return Storage::disk('public')->download(
            $reserva->contrato->pdf_path,
            'contrato-reserva-' . $reserva->cod . '.pdf'
        );
    }

    public function descargarPoliza(Reserva $reserva)
    {
        abort_unless($reserva->idusu === auth()->id(), 403);

        $reserva->load('polizaServicio');

        if (!$reserva->polizaServicio || !$reserva->polizaServicio->pdf_path) {
            abort(404, 'La póliza no ha sido generada.');
        }

        return Storage::disk('public')->download(
            $reserva->polizaServicio->pdf_path,
            'poliza-reserva-' . $reserva->cod . '.pdf'
        );
    }

    public function generarDocumentos(Reserva $reserva, ReservaDocumentoService $service)
    {
        abort_unless($reserva->idusu === auth()->id(), 403);

        $reserva->load([
            'user',
            'vehiculo.marca',
            'vehiculo.linea',
            'vehiculo.clase',
            'vehiculo.combustible',
            'vehiculo.ciudad',
            'vehiculo.poliza_vehiculo',
            'pago',
        ]);

        if (!$reserva->pago || $reserva->pago->estado !== 'aprobado') {
            return back()->with('error', 'Solo puedes generar documentos para reservas con pago aprobado.');
        }

        $service->generarYEnviar($reserva);

        return back()->with('success', 'Los documentos fueron generados y enviados al correo del usuario.');
    }

}