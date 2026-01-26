<?php

namespace App\Models\MER;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FotoVehiculo
 * 
 * @property int $cod
 * @property string $nom
 * @property string $ruta
 * @property string $dim
 * @property string $mim
 * @property int $pes
 * @property int|null $codveh
 * 
 * @property Vehiculo|null $vehiculo
 *
 * @package App\Models\MER
 */
class FotoVehiculo extends Model
{
	
	protected $table = 'fotos_vehiculo';
	protected $primaryKey = 'cod';
	public $timestamps = false;

	protected $fillable = [
		'nom',
		'ruta',
		'dim',
		'mim',
		'pes',
		'codveh',
	];

	public function vehiculo()
	{
		return $this->belongsTo(Vehiculo::class, 'codveh');
	}
}
