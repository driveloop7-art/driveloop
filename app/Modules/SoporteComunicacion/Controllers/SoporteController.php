<?php

namespace App\Modules\SoporteComunicacion\Controllers;

use App\Modules\SoporteComunicacion\Models\Soporte;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SoporteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("modules.SoporteComunicacion.index");
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
    public function show(Soporte $soporte)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Soporte $soporte)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Soporte $soporte)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Soporte $soporte)
    {
        //
    }
}