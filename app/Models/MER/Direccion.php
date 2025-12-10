<?php

namespace App\Models\MER;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Direccion
 * 
 * @property int $num
 * @property string $via
 * @property int $numpri
 * @property string|null $numpre
 * @property string|null $sufpri
 * @property int|null $numsec
 * @property string|null $compri
 * @property string|null $comsec
 * @property string|null $sufsec
 * @property int $codciu
 * 
 * @property Ciudad $ciudad
 * @property Collection|User[] $users
 *
 * @package App\Models\MER
 */
class Direccion extends Model
{
	protected $table = 'direcciones';
	protected $primaryKey = 'num';
	public $timestamps = false;

	protected $casts = [
		'numpri' => 'int',
		'numsec' => 'int',
		'codciu' => 'int'
	];

	protected $fillable = [
		'via',
		'numpri',
		'numpre',
		'sufpri',
		'numsec',
		'compri',
		'comsec',
		'sufsec',
		'codciu'
	];

	public function ciudad()
	{
		return $this->belongsTo(Ciudad::class, 'codciu');
	}

	public function users()
	{
		return $this->hasMany(User::class, 'numdir');
	}
}
