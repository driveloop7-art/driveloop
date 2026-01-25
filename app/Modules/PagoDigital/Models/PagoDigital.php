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
        'payment_method_id',
        'monto',
        'moneda',
        'payment_status_id',
        'datos_proveedor',
        'transaccion_id',
    ];

    protected $casts = [
        'datos_proveedor' => 'array',
    ];

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function paymentStatus()
    {
        return $this->belongsTo(PaymentStatus::class, 'payment_status_id');
    }

    public function reserva()
    {
        return $this->belongsTo(\App\Models\MER\Reserva::class, 'reserva_id');
    }
}
