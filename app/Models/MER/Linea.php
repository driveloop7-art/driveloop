<?php

namespace App\Models\MER;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Linea
 * 
 * @property int $cod
 * @property string $des
 * @property int $codmar
 * 
 * @property Marca $marca
 * @property Collection|Vehiculo[] $vehiculos
 *
 * @package App\Models\MER
 */
class Linea extends Model
{
	protected $table = 'lineas';
	protected $primaryKey = 'cod';
	public $timestamps = false;

	protected $casts = [
		'codmar' => 'int'
	];

	protected $fillable = [
		'des',
		'codmar'
	];

	public function marca()
	{
		return $this->belongsTo(Marca::class, 'codmar');
	}

	public function vehiculos()
	{
		return $this->hasMany(Vehiculo::class, 'codlin');
	}
}
