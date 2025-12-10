<?php

namespace App\Models\MER;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Combustible
 * 
 * @property int $cod
 * @property string $des
 * 
 * @property Collection|Vehiculo[] $vehiculos
 *
 * @package App\Models\MER
 */
class Combustible extends Model
{
	protected $table = 'combustibles';
	protected $primaryKey = 'cod';
	public $timestamps = false;

	protected $fillable = [
		'des'
	];

	public function vehiculos()
	{
		return $this->hasMany(Vehiculo::class, 'codcom');
	}
}
