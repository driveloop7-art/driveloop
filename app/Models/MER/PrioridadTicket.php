<?php

namespace App\Models\MER;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PrioridadTicket
 * 
 * @property int $cod
 * @property string $des
 * @property int|null $codtic
 * 
 * @property Ticket|null $ticket
 *
 * @package App\Models\MER
 */
class PrioridadTicket extends Model
{
	protected $table = 'prioridades_ticket';
	protected $primaryKey = 'cod';
	public $timestamps = false;

	protected $casts = [
		'codtic' => 'int'
	];

	protected $fillable = [
		'des',
		'codtic'
	];

	public function ticket()
	{
		return $this->belongsTo(Ticket::class, 'codtic');
	}
}
