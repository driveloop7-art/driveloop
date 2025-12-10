<?php

namespace App\Models\MER;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PolizaServicio
 * 
 * @property int $cod
 * @property string $ase
 * @property Carbon|null $fini
 * @property Carbon|null $ffin
 * @property int $codres
 * 
 * @property Reserva $reserva
 *
 * @package App\Models\MER
 */
class PolizaServicio extends Model
{
	protected $table = 'polizas_servicio';
	protected $primaryKey = 'cod';
	public $timestamps = false;

	protected $casts = [
		'fini' => 'datetime',
		'ffin' => 'datetime',
		'codres' => 'int'
	];

	protected $fillable = [
		'ase',
		'fini',
		'ffin',
		'codres'
	];

	public function reserva()
	{
		return $this->belongsTo(Reserva::class, 'codres');
	}
}
