<?php

namespace App\Modules\PagoDigital\Controllers;

use App\Modules\PagoDigital\Models\PagoDigital;
use App\Models\MER\Pago;
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
    public function index(Request $request, $reserva_id = null): View
    {
        // Si no viene ID en la URL, intentar obtenerlo del query parameter o usar el último para pruebas
        $id = $reserva_id ?? $request->query('reserva_id');
        
        $query = \App\Models\MER\Reserva::with([
            'user', 
            'vehiculo.marca', 
            'vehiculo.linea', 
            'vehiculo.ciudad', 
            'vehiculo.fotos'
        ]);

        if ($id) {
            $reserva = $query->find($id);
        } else {
            $reserva = $query->latest('cod')->first();
        }

        if (!$reserva) {
            abort(404, 'Reserva no encontrada');
        }

        $monto = $reserva->val ?? 150000;
        $reserva_id = $reserva->cod;

        return view("modules.PagoDigital.index", compact("reserva", "monto", "reserva_id"));
    }

    /**
     * Guardar información del pago en la base de datos.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'reserva_id' => 'required|exists:reservas,cod',
                'metodo_pago' => 'required|string',
                'monto' => 'required|numeric',
                'detalles' => 'required|array'
            ]);

            $pago = Pago::create([
                'reserva_id' => $request->reserva_id,
                'user_id' => auth()->id() ?? \App\Models\MER\Reserva::find($request->reserva_id)->codusu,
                'monto' => $request->monto,
                'metodo_pago' => $request->metodo_pago,
                'estado_pago' => 'pendiente',
                'detalles' => $request->detalles
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Información de pago guardada correctamente',
                'pago_id' => $pago->id
            ]);
        } catch (\Exception $e) {
            Log::error("Error al guardar pago: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la solicitud: ' . $e->getMessage()
            ], 500);
        }
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

