<?php

namespace App\Modules\ContratosGarantias\Controllers;

use App\Modules\ContratosGarantias\Models\Contratos;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContratosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("modules.ContratosGarantias.index");
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
    public function show(Contratos $contratos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contratos $contratos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contratos $contratos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contratos $contratos)
    {
        //
    }
}