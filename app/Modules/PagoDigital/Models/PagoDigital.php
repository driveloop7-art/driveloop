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
        'estado_pago',
        'datos_proveedor',
        'transaccion_id',
    ];

    protected $casts = [
        'datos_proveedor' => 'array',
    ];

    public function reserva()
    {
        return $this->belongsTo(\App\Models\MER\Reserva::class, 'reserva_id');
    }
}
