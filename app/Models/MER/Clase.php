<?php

namespace App\Models\MER;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Clase
 * 
 * @property int $cod
 * @property string $des
 * 
 * @property Collection|Vehiculo[] $vehiculos
 *
 * @package App\Models\MER
 */
class Clase extends Model
{
	protected $table = 'clases';
	protected $primaryKey = 'cod';
	public $timestamps = false;

	protected $fillable = [
		'des'
	];

	public function vehiculos()
	{
		return $this->hasMany(Vehiculo::class, 'codcla');
	}
}
