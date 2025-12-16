<?php

namespace App\Models\MER;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Ticket
 * 
 * @property int $cod
 * @property Carbon $feccre
 * @property Carbon|null $feccie
 * @property string $asu
 * @property string $des
 * @property string $res
 * @property int $codusu
 * @property int $codesttic
 * @property int $codpritic
 * 
 * @property EstadoTicket $estado_ticket
 * @property User $user
 * @property PrioridadTicket $prioridad_ticket
 *
 * @package App\Models\MER
 */
class Ticket extends Model
{
	protected $table = 'tickets';
	protected $primaryKey = 'cod';
	public $timestamps = false;

	protected $casts = [
		'feccre' => 'datetime',
		'feccie' => 'datetime',
		'codusu' => 'int',
		'codesttic' => 'int'
	];

	protected $fillable = [
		'feccre',
		'feccie',
		'asu',
		'des',
		'res',
		'codusu',
		'codesttic',
		'codpritic'
	];

	public function estado_ticket()
	{
		return $this->belongsTo(EstadoTicket::class, 'codesttic', 'cod');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'codusu', 'cod');
	}

	public function prioridad_ticket()
	{
		return $this->belongsTo(PrioridadTicket::class, 'codpritic', 'cod');
	}
}
