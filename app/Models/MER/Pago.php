<?php

namespace App\Models\MER;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Pago
 * 
 * @property int $id
 * @property int $reserva_id
 * @property int $user_id
 * @property float $monto
 * @property string $metodo_pago
 * @property string $estado_pago
 * @property array|null $detalles
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * 
 * @property Reserva $reserva
 * @property User $user
 *
 * @package App\Models\MER
 */
class Pago extends Model
{
    protected $table = 'pagos';

    protected $fillable = [
        'reserva_id',
        'user_id',
        'monto',
        'metodo_pago',
        'estado_pago',
        'detalles'
    ];

    protected $casts = [
        'reserva_id' => 'int',
        'user_id' => 'int',
        'monto' => 'float',
        'detalles' => 'json'
    ];

    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'reserva_id', 'cod');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
