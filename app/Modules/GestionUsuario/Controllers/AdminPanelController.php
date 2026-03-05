<?php

namespace App\Modules\GestionUsuario\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MER\User;
use App\Models\MER\Reserva;
use Illuminate\Http\Request;

class AdminPanelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        //Administra para enviar a la vista correspondiente segun el rol del usuario
        if ($user->hasRole('Administrador') || $user->hasRole('Soporte')) {
            return view('modules.GestionUsuario.admin.index');
        } else {
            // recopilamos únicamente las reservas del usuario autenticado
            $reservas = $user->reservas()
                ->with(['user', 'vehiculo.marca', 'vehiculo.linea', 'contrato'])
                ->orderBy('fecrea', 'desc')
                ->get();

            return view('modules.GestionUsuario.breeze.dashboard', compact('reservas'));
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }
    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
