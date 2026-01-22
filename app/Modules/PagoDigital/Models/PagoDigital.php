<?php

namespace App\Modules\PagoDigital\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagoDigital extends Model
{
    use HasFactory;

    protected $table = 'pago_digitals';

    protected $fillable = [
        'reserva_id',
        'metodo_pago',
        'monto',
        'moneda',
        'estado',
        'datos_proveedor',
        'transaccion_id',
    ];

    protected $casts = [
        'datos_proveedor' => 'array',
    ];
}
