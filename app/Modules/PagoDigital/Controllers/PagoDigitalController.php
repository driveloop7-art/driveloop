<?php

namespace App\Modules\PagoDigital\Controllers;

use App\Modules\PagoDigital\Models\PagoDigital;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail; // IMPORTANTE: Para enviar correos
use App\Mail\PagoRecibido;           // IMPORTANTE: Tu clase Mailable

class PagoDigitalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $monto = 1350000;
        // Obtenemos la última reserva para fines de demostración
        $reserva = \App\Models\MER\Reserva::latest('cod')->first();
        $reserva_id = $reserva ? $reserva->cod : 1;

        return view("modules.PagoDigital.index", compact("monto", "reserva_id"));
    }
/**
     * RF-007: Notificación de estado de pago (Webhook)
     */
    public function handleWebhook(Request $request)
    {
        try {
            // Log para ver todo lo que llega
            Log::info("Webhook recibido de Mercado Pago: ", $request->all());

            // Verificamos si existe el ID y el tipo
            $type = $request->input('type');
            
            if ($type === 'payment') {
                $paymentId = $request->input('data.id');
                Log::info("Procesando pago con ID: " . $paymentId);

                // --- INTEGRACIÓN SOLICITADA ---
                // Enviamos el correo usando la clase Mailable que ya tienes
                Mail::to('tu-correo@ejemplo.com')->send(new PagoRecibido($paymentId));
                Log::info("RF-007: Correo enviado para el pago: " . $paymentId);
                // ------------------------------
            }

            return response()->json(['message' => 'OK'], 200);

        } catch (\Exception $e) {
            // Si algo falla, lo registramos en el log pero respondemos 200 para que MP no reintente
            Log::error("Error en Webhook: " . $e->getMessage());
            return response()->json(['message' => 'Error capturado'], 200);
        }
    }
}

