<?php

namespace App\Models\MER;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EstadoTicket
 * 
 * @property int $cod
 * @property string|null $des
 *
 * @package App\Models\MER
 */
class EstadoTicket extends Model
{
	protected $table = 'estados_ticket';
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
