<?php

namespace App\Models\MER;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
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
 * @property int|null $codesttic
 * 
 * @property EstadoTicket|null $estado_ticket
 * @property User $user
 * @property Collection|PrioridadTicket[] $prioridades_tickets
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
		'codesttic'
	];

	public function estado_ticket()
	{
		return $this->belongsTo(EstadoTicket::class, 'codesttic');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'codusu', 'cod');
	}

	public function prioridades_tickets()
	{
		return $this->hasMany(PrioridadTicket::class, 'codtic');
	}
}
