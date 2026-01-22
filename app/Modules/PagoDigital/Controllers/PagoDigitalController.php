<?php

namespace App\Modules\PagoDigital\Controllers;

use App\Modules\PagoDigital\Models\PagoDigital;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
        $rules = [
            'metodo_pago' => 'required|string|in:card,pse,nequi',
        ];

        if ($request->metodo_pago === 'card') {
            $rules['card_number'] = 'required|string';
            $rules['card_holder'] = 'required|string|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/';
            $rules['card_expiry'] = 'required|string|regex:/^(0[1-9]|1[0-2])\/\d{2}$/';
            $rules['card_cvv'] = 'required|string';
            $rules['card_doc'] = 'required|numeric|digits_between:8,10';
        } elseif ($request->metodo_pago === 'pse') {
            $rules['pse_name'] = 'required|string|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/';
            $rules['pse_lastname'] = 'required|string|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/';
            $rules['pse_doc'] = 'required|numeric|digits_between:8,10';
            $rules['pse_phone'] = 'required|string';
            $rules['pse_bank'] = 'required|string';
        } elseif ($request->metodo_pago === 'nequi') {
            $rules['nequi_name'] = 'required|string|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/';
            $rules['nequi_lastname'] = 'required|string|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/';
            $rules['nequi_phone'] = 'required|string';
        }

        $validated = $request->validate($rules);

        $pago = new PagoDigital();
        $pago->metodo_pago = $request->metodo_pago;
        $pago->monto = 150000; // Hardcoded for now based on mockup
        $pago->estado = 'pendiente';

        $datos = [];
        if ($request->metodo_pago === 'card') {
            $datos = $request->only(['card_number', 'card_holder', 'card_expiry', 'card_doc']);
            $datos['card_number'] = '**** **** **** ' . substr($request->card_number, -4);
        } elseif ($request->metodo_pago === 'pse') {
            $datos = $request->only(['pse_name', 'pse_lastname', 'pse_doc', 'pse_phone', 'pse_bank']);
        } elseif ($request->metodo_pago === 'nequi') {
            $datos = $request->only(['nequi_name', 'nequi_lastname', 'nequi_phone']);
        }

        $pago->datos_proveedor = $datos;

        // Generate random acceptance (50% chance)
        $aceptado = rand(0, 1) === 1;
        $pago->estado = $aceptado ? 'aceptado' : 'rechazado';

        $pago->save();

        // Redirect to result page with payment ID
        return redirect()->route('pago.digital.resultado', ['id' => $pago->id]);
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
