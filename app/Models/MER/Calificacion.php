<?php

namespace App\Models\MER;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Calificacion
 * 
 * @property int $cod
 * @property int $val
 * @property Carbon|null $fec
 * @property int|null $codres
 * 
 * @property Reserva|null $reserva
 *
 * @package App\Models\MER
 */
class Calificacion extends Model
{
	protected $table = 'calificaciones';
	protected $primaryKey = 'cod';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'cod' => 'int',
		'val' => 'int',
		'fec' => 'datetime',
		'codres' => 'int'
	];

	protected $fillable = [
		'val',
		'fec',
		'codres'
	];

	public function reserva()
	{
		return $this->belongsTo(Reserva::class, 'codres');
	}
}
