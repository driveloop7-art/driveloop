<?php

namespace App\Models\MER;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EstadoTicket
 * 
 * @property int $cod
 * @property string|null $des
 * 
 * @property Collection|Ticket[] $tickets
 *
 * @package App\Models\MER
 */
class EstadoTicket extends Model
{
	protected $table = 'estados_ticket';
	protected $primaryKey = 'cod';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'cod' => 'int'
	];

	protected $fillable = [
		'des'
	];

	public function tickets()
	{
		return $this->hasMany(Ticket::class, 'codesttic');
	}
}
