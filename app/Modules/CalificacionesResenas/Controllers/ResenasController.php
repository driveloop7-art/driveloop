<?php

namespace App\Modules\CalificacionesResenas\Controllers;

use App\Modules\CalificacionesResenas\Models\Resenas;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResenasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("modules.CalificacionesResenas.index");
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
    public function show(Resenas $resenas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Resenas $resenas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Resenas $resenas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resenas $resenas)
    {
        //
    }
}