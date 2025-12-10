<?php

namespace App\Models\MER;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Marca
 * 
 * @property int $cod
 * @property string $des
 * 
 * @property Collection|Linea[] $lineas
 * @property Collection|Vehiculo[] $vehiculos
 *
 * @package App\Models\MER
 */
class Marca extends Model
{
	protected $table = 'marcas';
	protected $primaryKey = 'cod';
	public $timestamps = false;

	protected $fillable = [
		'des'
	];

	public function lineas()
	{
		return $this->hasMany(Linea::class, 'codmar');
	}

	public function vehiculos()
	{
		return $this->hasMany(Vehiculo::class, 'codmar');
	}
}
