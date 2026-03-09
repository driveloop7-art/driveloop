<?php

namespace App\Models\MER;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Contrato
 * 
 * @property int $id
 * @property int $reserva_id
 * @property string $codigo_verificacion
 * @property string|null $ruta_pdf
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * 
 * @property Reserva $reserva
 *
 * @package App\Models\MER
 */
class Contrato extends Model
{
    protected $table = 'contratos';

    protected $fillable = [
        'reserva_id',
        'codigo_verificacion',
        'ruta_pdf'
    ];

    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'reserva_id', 'cod');
    }
}
