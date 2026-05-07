<?php

namespace App\Models\MER;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pagos';

    protected $fillable = [
        'codres',
        'idusu',
        'referencia',
        'metodo',
        'monto',
        'estado',
        'moneda',
        'fecha_pago',
        'detalle',
        'provider',
        'external_payment_id',
        'external_reference',
        'status_detail',
        'webhook_payload',
        'approved_at',
    ];

    protected $casts = [
        'monto' => 'float',
        'fecha_pago' => 'datetime',
        'detalle' => 'array',
        'webhook_payload' => 'array',
        'approved_at' => 'datetime',
    ];

    protected $appends = [
        'estado_normalizado',
    ];

    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'codres', 'cod');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'idusu', 'id');
    }

    public function getEstadoNormalizadoAttribute(): string
    {
        $estado = strtolower(trim((string) $this->estado));

        return match ($estado) {
            'approved', 'aprobado' => 'aprobado',
            'pending', 'pendiente' => 'pendiente',
            'rejected', 'rechazado', 'failed', 'fallido' => 'rechazado',
            default => 'pendiente',
        };
    }
}