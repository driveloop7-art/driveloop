<?php

namespace App\Models\MER;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Resena
 * 
 * @property int $cod
 * @property string $des
 * @property Carbon|null $fec
 * @property int|null $codres
 * 
 * @property Reserva|null $reserva
 *
 * @package App\Models\MER
 */
class Resena extends Model
{
	protected $table = 'resenas';
	protected $primaryKey = 'cod';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'cod' => 'int',
		'fec' => 'datetime',
		'codres' => 'int'
	];

	protected $fillable = [
		'des',
		'fec',
		'codres'
	];

	public function reserva()
	{
		return $this->belongsTo(Reserva::class, 'codres');
	}
}
