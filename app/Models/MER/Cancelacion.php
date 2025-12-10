<?php

namespace App\Models\MER;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Cancelacion
 * 
 * @property int $cod
 * @property int $codres
 * @property Carbon $fec
 * 
 * @property Reserva $reserva
 * @property Collection|Reembolso[] $reembolsos
 *
 * @package App\Models\MER
 */
class Cancelacion extends Model
{
	protected $table = 'cancelaciones';
	protected $primaryKey = 'cod';
	public $timestamps = false;

	protected $casts = [
		'codres' => 'int',
		'fec' => 'datetime'
	];

	protected $fillable = [
		'codres',
		'fec'
	];

	public function reserva()
	{
		return $this->belongsTo(Reserva::class, 'codres');
	}

	public function reembolsos()
	{
		return $this->hasMany(Reembolso::class, 'codcan');
	}
}
