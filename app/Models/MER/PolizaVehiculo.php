<?php

namespace App\Models\MER;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PolizaVehiculo
 * 
 * @property int $cod
 * @property string $ase
 * @property Carbon|null $fini
 * @property Carbon|null $ffin
 * 
 * @property Collection|Vehiculo[] $vehiculos
 *
 * @package App\Models\MER
 */
class PolizaVehiculo extends Model
{
	protected $table = 'polizas_vehiculo';
	protected $primaryKey = 'cod';
	public $timestamps = false;

	protected $casts = [
		'fini' => 'datetime',
		'ffin' => 'datetime'
	];

	protected $fillable = [
		'ase',
		'fini',
		'ffin'
	];

	public function vehiculos()
	{
		return $this->hasMany(Vehiculo::class, 'codpol');
	}
}
