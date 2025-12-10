<?php

namespace App\Models\MER;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Reembolso
 * 
 * @property int $cod
 * @property Carbon|null $fec
 * @property float|null $val
 * @property int $codcan
 * 
 * @property Cancelacion $cancelacion
 *
 * @package App\Models\MER
 */
class Reembolso extends Model
{
	protected $table = 'reembolsos';
	protected $primaryKey = 'cod';
	public $timestamps = false;

	protected $casts = [
		'fec' => 'datetime',
		'val' => 'float',
		'codcan' => 'int'
	];

	protected $fillable = [
		'fec',
		'val',
		'codcan'
	];

	public function cancelacion()
	{
		return $this->belongsTo(Cancelacion::class, 'codcan');
	}
}
