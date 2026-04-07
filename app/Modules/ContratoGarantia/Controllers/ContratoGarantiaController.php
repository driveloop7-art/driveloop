<?php

namespace App\Modules\ContratoGarantia\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MER\Contrato;
use App\Models\MER\Reserva;
use App\Mail\ContratoAlquilerMail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ContratoGarantiaController extends Controller
{
    public function index()
    {
        /** @var \App\Models\MER\User|null $user */
        $user = Auth::user(); // Obtenemos el objeto usuario completo

        if (!$user) {
            abort(403, 'Acceso no autorizado.');
        }

        $query = Reserva::with(['user', 'vehiculo.marca', 'vehiculo.linea', 'contrato']);

        // Corrección: el chequeo de roles se hace sobre el objeto $user, no sobre el ID
        if (! ($user->hasRole('Administrador') || $user->hasRole('Soporte'))) {
            $query->where('user_id', $user->id);
        }

        $reservas = $query->orderBy('fecrea', 'desc')->get();

        return view("modules.ContratoGarantia.index", compact('reservas'));
    }

    public function generarContrato($codReserva)
    {
        $reserva = Reserva::with(['user', 'vehiculo.marca', 'vehiculo.linea', 'contrato'])->findOrFail($codReserva);

        if ($reserva->contrato) {
            $ruta = storage_path('app/public/contratos/contrato_' . $reserva->cod . '.pdf');
            if (file_exists($ruta)) {
                return response()->file($ruta, ['Content-Type' => 'application/pdf']);
            }
        }

        $codigo = strtoupper(bin2hex(random_bytes(4)));

        // PASO 3: Ruta de vista actualizada
        $pdf = Pdf::loadView('modules.ContratoGarantia.pdf.contrato', compact('reserva', 'codigo'));

        Contrato::create([
            'reserva_id'          => $reserva->cod,
            'codigo_verificacion' => $codigo,
            'ruta_pdf'            => "contratos/contrato_{$reserva->cod}.pdf"
        ]);

        $pdfOutput = $pdf->output();
        Storage::put("public/contratos/contrato_{$reserva->cod}.pdf", $pdfOutput);

        if ($reserva->user && $reserva->user->email) {
            Mail::to($reserva->user->email)->send(new ContratoAlquilerMail($reserva, $pdfOutput));
        }

        return $pdf->stream("contrato_{$reserva->cod}.pdf");
    }

    public function descargarActaEntrega($codReserva)
    {
        $reserva = Reserva::with(['user', 'vehiculo.marca', 'vehiculo.linea', 'contrato'])->findOrFail($codReserva);

        // PASO 3: Ruta de vista actualizada
        $pdf = Pdf::loadView('modules.ContratoGarantia.pdf.acta_entrega', compact('reserva'));

        return $pdf->stream("acta_entrega_reserva_{$reserva->cod}.pdf");
    }

    public function enviarContrato($codReserva)
    {
        $reserva = Reserva::with(['user', 'vehiculo.marca', 'vehiculo.linea', 'contrato'])->findOrFail($codReserva);

        $codigo = $reserva->contrato
            ? $reserva->contrato->codigo_verificacion
            : strtoupper(bin2hex(random_bytes(4)));

        // PASO 3: Ruta de vista actualizada
        $pdf = Pdf::loadView('modules.ContratoGarantia.pdf.contrato', compact('reserva', 'codigo'));
        $pdfOutput = $pdf->output();

        if (! $reserva->contrato) {
            Contrato::create([
                'reserva_id'          => $reserva->cod,
                'codigo_verificacion' => $codigo,
                'ruta_pdf'            => "contratos/contrato_{$reserva->cod}.pdf"
            ]);
            Storage::put("public/contratos/contrato_{$reserva->cod}.pdf", $pdfOutput);
        }

        if ($reserva->user && $reserva->user->email) {
            Mail::to($reserva->user->email)->send(new ContratoAlquilerMail($reserva, $pdfOutput));
        }

        return back()->with('message', 'Contrato enviado exitosamente al correo del cliente.');
    }



    public function aceptarContrato(\Illuminate\Http\Request $request, $codReserva)
    {
        $reserva = Reserva::with(['user', 'contrato'])->findOrFail($codReserva);

        // Validar que la reserva pertenezca al usuario autenticado (si aplica seguridad extra)
        if ($reserva->user_id !== Auth::id()) {
            return back()->with('message', 'No tienes permiso para aceptar este contrato.');
        }
        if (!$reserva->contrato) {
            return back()->with('message', 'El contrato aún no ha sido generado.');
        }

        $reserva->contrato->update([
            'aceptado_arrendatario' => true,
            'fecha_aceptacion_arrendatario' => now(),
            'ip_arrendatario' => $request->ip(),
            'user_agent_arrendatario' => $request->userAgent()
        ]);

        return back()->with('message', '¡Contrato aceptado y firmado electrónicamente con éxito!');
    }
}
