<?php

namespace App\Services\Reservas;

use App\Mail\ReservaDocumentosEmitidos;
use App\Models\MER\ContratoReserva;
use App\Models\MER\PolizaServicio;
use App\Models\MER\Reserva;
use App\Models\MER\User;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class ReservaDocumentoService
{
    public function generarYEnviar(Reserva $reserva): void
    {
        $reserva->loadMissing([
            'user',
            'vehiculo.marca',
            'vehiculo.linea',
            'vehiculo.clase',
            'vehiculo.combustible',
            'vehiculo.ciudad',
            'vehiculo.poliza_vehiculo',
            'pago',
        ]);

        $poliza = $this->generarPoliza($reserva);
        $contrato = $this->generarContrato($reserva);

        if ($reserva->user && $reserva->user->email) {
            Mail::to($reserva->user->email)->send(
                new ReservaDocumentosEmitidos($reserva, $contrato->pdf_path, $poliza->pdf_path)
            );
        }
    }

    public function generarPoliza(Reserva $reserva): PolizaServicio
    {
        $existente = PolizaServicio::where('codres', $reserva->cod)->first();

        if ($existente && $existente->pdf_path && Storage::disk('public')->exists($existente->pdf_path)) {
            return $existente;
        }

        $numeroPoliza = 'POL-' . now()->format('Ymd') . '-' . str_pad((string) $reserva->cod, 6, '0', STR_PAD_LEFT);

        $poliza = $existente ?: new PolizaServicio();

        $poliza->codres = $reserva->cod;
        $poliza->numero_poliza = $numeroPoliza;
        $poliza->ase = 'Seguros Andinos S.A.';
        $poliza->empresa_aseguradora = 'Seguros Andinos S.A.';
        $poliza->tipo_cobertura = 'Todo Riesgo Temporal';
        $poliza->fini = $reserva->fecini;
        $poliza->ffin = $reserva->fecfin;
        $poliza->valor_asegurado = 80000000;
        $poliza->deducible = '10% del valor del siniestro, mínimo 1 SMMLV';
        $poliza->estado = 'emitida';
        $poliza->observaciones = 'Póliza temporal emitida únicamente por la vigencia de la reserva y asociada al servicio intermediado por DriveLoop.';
        $poliza->save();

        $html = view('modules.Reservas.pdf.poliza', [
            'reserva' => $reserva,
            'poliza' => $poliza,
            'usuario' => $reserva->user,
            'vehiculo' => $reserva->vehiculo,
        ])->render();

        $pdfOutput = $this->renderPdf($html);

        $path = "reservas/{$reserva->cod}/poliza_{$poliza->numero_poliza}.pdf";
        Storage::disk('public')->put($path, $pdfOutput);

        $poliza->pdf_path = $path;
        $poliza->save();

        return $poliza;
    }

    public function generarContrato(Reserva $reserva): ContratoReserva
    {
        $existente = ContratoReserva::where('codres', $reserva->cod)->first();

        if ($existente && $existente->pdf_path && Storage::disk('public')->exists($existente->pdf_path)) {
            return $existente;
        }

        $numeroContrato = 'CTR-' . now()->format('Ymd') . '-' . str_pad((string) $reserva->cod, 6, '0', STR_PAD_LEFT);

        $contrato = $existente ?: new ContratoReserva();
        $contrato->codres = $reserva->cod;
        $contrato->numero_contrato = $numeroContrato;
        $contrato->fecha_emision = now();
        $contrato->estado = 'generado';
        $contrato->save();

        $propietario = null;
        if ($reserva->vehiculo?->user_id) {
            $propietario = User::find($reserva->vehiculo->user_id);
        }

        $html = view('modules.Reservas.pdf.contrato', [
            'reserva' => $reserva,
            'contrato' => $contrato,
            'usuario' => $reserva->user,
            'vehiculo' => $reserva->vehiculo,
            'propietario' => $propietario,
        ])->render();

        $pdfOutput = $this->renderPdf($html);

        $path = "reservas/{$reserva->cod}/contrato_{$contrato->numero_contrato}.pdf";
        Storage::disk('public')->put($path, $pdfOutput);

        $contrato->pdf_path = $path;
        $contrato->save();

        return $contrato;
    }

    private function renderPdf(string $html): string
    {
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->output();
    }
}