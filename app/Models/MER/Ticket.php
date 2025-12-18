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
 * @property User $user
 * @property EstadoTicket $estado_ticket
 * @property PrioridadTicket $prioridad_ticket
 *
 * @package App\Models\MER
 */
class Ticket extends Model
{
	protected $table = 'tickets';
	protected $primaryKey = 'cod';
	public $incrementing = true;
	public $timestamps = false;

	protected $casts = [
		'feccre' => 'datetime',
		'feccie' => 'datetime',
		'asu' => 'string|max:140',
		'des' => 'string|max:900',
		'res' => 'string|max:900',
		'codusu' => 'int',
		'codesttic' => 'int',
		'codpritic' => 'int'
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

	public function user()
	{
		return $this->belongsTo(User::class, 'codusu', 'cod');
	}
	public function estado_ticket()
	{
		return $this->belongsTo(EstadoTicket::class, 'codesttic', 'cod');
	}
	public function prioridad_ticket()
	{
		return $this->belongsTo(PrioridadTicket::class, 'codpritic', 'cod');
	}
}
