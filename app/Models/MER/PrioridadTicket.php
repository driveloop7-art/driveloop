<?php

namespace App\Models\MER;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PrioridadTicket
 * 
 * @property int $cod
 * @property string $des
 *
 * @package App\Models\MER
 */
class PrioridadTicket extends Model
{
	protected $table = 'prioridades_ticket';
	protected $primaryKey = 'cod';
	public $incrementing = true;
	public $timestamps = false;

	protected $casts = [
		'des' => 'string|max:45'
	];

	protected $fillable = [
		'des'
	];
}
