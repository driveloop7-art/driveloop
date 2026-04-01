<?php

namespace App\Modules\PagoDigital\Controllers;

use App\Modules\PagoDigital\Models\PagoDigital;
use App\Models\MER\Pago;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB; // IMPORTANTE: Para enviar correos
use App\Mail\PagoRecibido;           // IMPORTANTE: Tu clase Mailable

class PagoDigitalController extends Controller
{
    public function index(Request $request, $reserva_id = null): View
    {
        $id = $reserva_id ?? $request->query('reserva_id');

        $query = \App\Models\MER\Reserva::with(['user', 'vehiculo']);

        if ($id) {
            $reserva = $query->find($id);
        } else {
            $reserva = $query->latest('cod')->first();
        }

        if (!$reserva) {
            abort(404, 'Reserva no encontrada');
        }

        // ... dentro de la función index ...

        $monto = $reserva->val ?? 150000;
        $reserva_id = $reserva->cod;

        // Buscamos los nombres reales usando la columna 'des'
        $marcaNombre = DB::table('marcas')
            ->where('cod', $reserva->vehiculo->codmar)
            ->value('des') ?? 'Sin marca';

        $ciudadNombre = DB::table('ciudades')
            ->where('cod', $reserva->vehiculo->codciu)
            ->value('des') ?? 'Sin ubicación';

        $lineaNombre = DB::table('lineas')
            ->where('cod', $reserva->vehiculo->codlin)
            ->value('des') ?? '';

        return view("modules.PagoDigital.index", compact(
            "reserva",
            "monto",
            "reserva_id",
            "marcaNombre",
            "ciudadNombre",
            "lineaNombre"
        ));
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

            $reserva = \App\Models\MER\Reserva::find($request->reserva_id);
            $user = $request->user();
            $userId = $user?->id;

            if (!$userId && $reserva) {
                $userId = $reserva->codusu;
            }

            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró usuario asociado a la reserva y no hay sesión activa'
                ], 422);
            }

            $pago = Pago::create([
                'reserva_id' => $request->reserva_id,
                'user_id' => $userId,
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

    public function handleWebhook(Request $request)
    {
        try {
            Log::info("Webhook recibido de Mercado Pago: ", $request->all());

            $type = $request->input('type');

            if ($type === 'payment') {
                $paymentId = $request->input('data.id');
                Log::info("Procesando pago con ID: " . $paymentId);

                Mail::to('tu-correo@ejemplo.com')->send(new PagoRecibido($paymentId));
                Log::info("RF-007: Correo enviado para el pago: " . $paymentId);
                // ------------------------------
            }

            return response()->json(['message' => 'OK'], 200);
        } catch (\Exception $e) {
            Log::error("Error en Webhook: " . $e->getMessage());
            return response()->json(['message' => 'Error capturado'], 200);
        }
    }
}
