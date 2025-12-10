<?php

namespace App\Models\MER;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EstadoReserva
 * 
 * @property int $cod
 * @property string $des
 * 
 * @property Collection|Reserva[] $reservas
 *
 * @package App\Models\MER
 */
class EstadoReserva extends Model
{
	protected $table = 'estados_reserva';
	protected $primaryKey = 'cod';
	public $timestamps = false;

	protected $fillable = [
		'des'
	];

	public function reservas()
	{
		return $this->hasMany(Reserva::class, 'codestres');
	}
}
