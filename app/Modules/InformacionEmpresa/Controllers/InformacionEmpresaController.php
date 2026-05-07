<?php

namespace App\Modules\InformacionEmpresa\Controllers;

use App\Http\Controllers\Controller;

class InformacionEmpresaController extends Controller
{
    public function nosotros()
    {
        return view('modules.InformacionEmpresa.nosotros');
    }

    public function servicios()
    {
        return view('modules.InformacionEmpresa.servicios');
    }

    public function comoFunciona()
    {
        return view('modules.InformacionEmpresa.como-funciona');
    }
}
