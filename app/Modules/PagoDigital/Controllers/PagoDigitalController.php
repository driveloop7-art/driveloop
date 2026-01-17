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
        //
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