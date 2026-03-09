<?php

namespace App\Modules\ContratoGarantia\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MER\Contrato;
use App\Models\MER\Reserva;
use App\Mail\ContratoAlquilerMail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ContratoGarantiaController extends Controller
{
    public function index()
    {
        // mostrar todas las reservas para administradores/soporte, y solo las propias para usuarios normales
        $user = auth()->user();
        $query = Reserva::with(['user', 'vehiculo.marca', 'vehiculo.linea', 'contrato']);

        if (! ($user->hasRole('Administrador') || $user->hasRole('Soporte'))) {
            $query->where('user_id', $user->id);
        }

        $reservas = $query->orderBy('fecrea', 'desc')->get();

        return view("modules.ContratoGarantia.index", compact('reservas'));
    }

    public function generarContrato($codReserva)
    {
        $reserva = Reserva::with(['user', 'vehiculo.marca', 'vehiculo.linea', 'contrato'])->findOrFail($codReserva);

        // Si ya existe un contrato, devolver el PDF existente
        if ($reserva->contrato) {
            $ruta = storage_path('app/public/contratos/contrato_' . $reserva->cod . '.pdf');
            if (file_exists($ruta)) {
                return response()->file($ruta, ['Content-Type' => 'application/pdf']);
            }
        }

        // Generar código único de verificación
        $codigo = strtoupper(bin2hex(random_bytes(4)));

        // Generar PDF
        $pdf = Pdf::loadView('pdf.contrato', compact('reserva', 'codigo'));

        // Registrar en base de datos
        Contrato::create([
            'reserva_id'          => $reserva->cod,
            'codigo_verificacion' => $codigo,
            'ruta_pdf'            => "contratos/contrato_{$reserva->cod}.pdf"
        ]);

        // Guardar el archivo físicamente
        $pdfOutput = $pdf->output();
        Storage::put("public/contratos/contrato_{$reserva->cod}.pdf", $pdfOutput);

        // Enviar el correo al cliente
        if ($reserva->user && $reserva->user->email) {
            Mail::to($reserva->user->email)->send(new ContratoAlquilerMail($reserva, $pdfOutput));
        }

        return $pdf->stream("contrato_{$reserva->cod}.pdf");
    }

    public function descargarActaEntrega($codReserva)
    {
        $reserva = Reserva::with(['user', 'vehiculo.marca', 'vehiculo.linea', 'contrato'])->findOrFail($codReserva);

        // Generar PDF
        $pdf = Pdf::loadView('pdf.acta_entrega', compact('reserva'));

        return $pdf->stream("acta_entrega_reserva_{$reserva->cod}.pdf");
    }

    public function enviarContrato($codReserva)
    {
        $reserva = Reserva::with(['user', 'vehiculo.marca', 'vehiculo.linea', 'contrato'])->findOrFail($codReserva);

        // Generar código único de verificación (o usar el existente)
        $codigo = $reserva->contrato
            ? $reserva->contrato->codigo_verificacion
            : strtoupper(bin2hex(random_bytes(4)));

        // Generar PDF
        $pdf = Pdf::loadView('pdf.contrato', compact('reserva', 'codigo'));
        $pdfOutput = $pdf->output();

        // Si no existe contrato, registrarlo
        if (! $reserva->contrato) {
            Contrato::create([
                'reserva_id'          => $reserva->cod,
                'codigo_verificacion' => $codigo,
                'ruta_pdf'            => "contratos/contrato_{$reserva->cod}.pdf"
            ]);
            Storage::put("public/contratos/contrato_{$reserva->cod}.pdf", $pdfOutput);
        }

        // Enviar el correo al cliente
        if ($reserva->user && $reserva->user->email) {
            Mail::to($reserva->user->email)->send(new ContratoAlquilerMail($reserva, $pdfOutput));
        }

        return back()->with('message', 'Contrato enviado exitosamente al correo del cliente.');
    }
}
