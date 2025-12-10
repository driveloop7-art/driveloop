<?php

namespace App\Models\MER;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Ciudad
 * 
 * @property int $cod
 * @property string $des
 * @property int $coddep
 * 
 * @property Departamento $departamento
 * @property Collection|Direccione[] $direcciones
 * @property Collection|User[] $users
 *
 * @package App\Models\MER
 */
class Ciudad extends Model
{
	protected $table = 'ciudades';
	protected $primaryKey = 'cod';
	public $timestamps = false;

	protected $casts = [
		'coddep' => 'int'
	];

	protected $fillable = [
		'des',
		'coddep'
	];

	public function departamento()
	{
		return $this->belongsTo(Departamento::class, 'coddep');
	}

	public function direcciones()
	{
		return $this->hasMany(Direccion::class, 'codciu');
	}

	public function users()
	{
		return $this->hasMany(User::class, 'codciu');
	}
}
