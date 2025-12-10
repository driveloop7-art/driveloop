<?php

namespace App\Models\MER;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Departamento
 * 
 * @property int $cod
 * @property string $des
 * 
 * @property Collection|Ciudad[] $ciudades
 *
 * @package App\Models\MER
 */
class Departamento extends Model
{
	protected $table = 'departamentos';
	protected $primaryKey = 'cod';
	public $timestamps = false;

	protected $fillable = [
		'des'
	];

	public function ciudades()
	{
		return $this->hasMany(Ciudad::class, 'coddep');
	}
}
