<?php

namespace App\Modules\PagoDigital\Controllers;

use App\Modules\PagoDigital\Models\PagoDigital;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class PagoDigitalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view("modules.PagoDigital.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Log incoming request for debugging
            Log::info('Payment request received', [
                'metodo_pago' => $request->metodo_pago,
                'all_data' => $request->all()
            ]);

            $rules = [
                'metodo_pago' => 'required|string|in:card,pse,nequi',
            ];

            $messages = [
                'metodo_pago.required' => 'Debe seleccionar un método de pago.',
                'metodo_pago.in' => 'El método de pago seleccionado no es válido.',
            ];

            if ($request->metodo_pago === 'card') {
                $rules['card_number'] = 'required|numeric|digits:16';
                $rules['card_holder'] = ['required', 'string', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'];
                $rules['card_expiry'] = ['required', 'string', 'regex:/^(0[1-9]|1[0-2])\/\d{2}$/'];
                $rules['card_cvv'] = 'required|string|min:3|max:4';
                $rules['card_doc'] = 'required|numeric|digits_between:8,10';

                $messages = array_merge($messages, [
                    'card_number.required' => 'El número de tarjeta es obligatorio.',
                    'card_number.numeric' => 'El número de tarjeta solo debe contener números.',
                    'card_number.digits' => 'El número de tarjeta debe tener exactamente 16 dígitos. Verifique que no le falten o sobren números.',
                    'card_holder.required' => 'El nombre del titular es obligatorio.',
                    'card_holder.regex' => 'El nombre del titular solo puede contener letras.',
                    'card_expiry.required' => 'La fecha de vencimiento es obligatoria.',
                    'card_expiry.regex' => 'La fecha de vencimiento debe tener formato MM/AA.',
                    'card_cvv.required' => 'El código CVV es obligatorio.',
                    'card_cvv.min' => 'El código CVV debe tener al menos 3 dígitos.',
                    'card_doc.required' => 'El documento del titular es obligatorio.',
                    'card_doc.digits_between' => 'El documento debe tener entre 8 y 10 dígitos.',
                ]);
            } elseif ($request->metodo_pago === 'pse') {
                $rules['pse_name'] = 'required|string|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/';
                $rules['pse_lastname'] = 'required|string|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/';
                $rules['pse_doc'] = 'required|numeric|digits_between:8,10';
                $rules['pse_phone'] = 'required|string';
                $rules['pse_bank'] = 'required|string';

                $messages = array_merge($messages, [
                    'pse_name.required' => 'El nombre es obligatorio.',
                    'pse_lastname.required' => 'El apellido es obligatorio.',
                    'pse_doc.required' => 'El documento es obligatorio.',
                    'pse_phone.required' => 'El número celular es obligatorio.',
                    'pse_bank.required' => 'Debe seleccionar un banco.',
                ]);
            } elseif ($request->metodo_pago === 'nequi') {
                $rules['nequi_name'] = 'required|string|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/';
                $rules['nequi_lastname'] = 'required|string|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/';
                $rules['nequi_phone'] = 'required|string';

                $messages = array_merge($messages, [
                    'nequi_name.required' => 'El nombre es obligatorio.',
                    'nequi_lastname.required' => 'El apellido es obligatorio.',
                    'nequi_phone.required' => 'El número de teléfono es obligatorio.',
                ]);
            }

            $validated = $request->validate($rules, $messages);

            $pago = new PagoDigital();

            // Get ID for payment method
            $methodId = \Illuminate\Support\Facades\DB::table('payment_methods')
                ->where('name', $request->metodo_pago)
                ->value('id');

            $pago->payment_method_id = $methodId;
            $pago->monto = 150000; // Hardcoded for now based on mockup

            // Get ID for pending status
            $pendingStatusId = \Illuminate\Support\Facades\DB::table('payment_statuses')
                ->where('name', 'pendiente')
                ->value('id');

            $pago->payment_status_id = $pendingStatusId;

            $datos = [];
            if ($request->metodo_pago === 'card') {
                $datos = $request->only(['card_number', 'card_holder', 'card_expiry', 'card_doc']);
                // Mask card number for security
                $datos['card_number'] = '**** **** **** ' . substr($request->card_number, -4);
            } elseif ($request->metodo_pago === 'pse') {
                $datos = $request->only(['pse_name', 'pse_lastname', 'pse_doc', 'pse_phone', 'pse_bank']);
            } elseif ($request->metodo_pago === 'nequi') {
                $datos = $request->only(['nequi_name', 'nequi_lastname', 'nequi_phone']);
            }

            // Should link to a reservation here if available
            // $pago->reserva_id = $request->reserva_id; 

            $pago->datos_proveedor = $datos;

            // Generate random acceptance (50% chance)
            $aceptado = rand(0, 1) === 1;
            $statusName = $aceptado ? 'aceptado' : 'rechazado';

            $pago->payment_status_id = \Illuminate\Support\Facades\DB::table('payment_statuses')
                ->where('name', $statusName)
                ->value('id');

            $pago->save();

            Log::info('Payment saved successfully', ['id' => $pago->id, 'status_id' => $pago->payment_status_id]);

            // Redirect to result page with payment ID
            return redirect()->route('pago.digital.resultado', ['id' => $pago->id]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error in payment', [
                'errors' => $e->errors(),
                'request' => $request->all()
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error processing payment', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors(['error' => 'Ocurrió un error al procesar el pago. Por favor, intente nuevamente.'])->withInput();
        }
    }

    /**
     * Show payment result
     */
    public function resultado($id)
    {
        $pago = PagoDigital::findOrFail($id);
        return view('modules.PagoDigital.resultado', compact('pago'));
    }


    /**
     * Display the specified resource.
     */
    public function show(PagoDigital $pagodigital)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PagoDigital $pagodigital)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PagoDigital $pagodigital)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PagoDigital $pagodigital)
    {
        //
    }
}
