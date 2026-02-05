<?php

namespace App\Models\MER;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Ticket
 * 
 * @property string $cod
 * @property Carbon $feccre
 * @property Carbon|null $feccie
 * @property string $asu
 * @property string $des
 * @property string $urlpdf
 * @property string $res
 * @property int $idusu
 * @property int $codesttic
 * @property int $codpritic
 * @property int $codres
 * 
 * @property User $user
 * @property EstadoTicket $estado_ticket
 * @property PrioridadTicket $prioridad_ticket
 * @property Reserva $reserva
 *
 * @package App\Models\MER
 */
class Ticket extends Model
{
	protected $table = 'tickets';
	protected $primaryKey = 'cod';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'feccre' => 'datetime',
		'fecpro' => 'datetime',
		'feccie' => 'datetime',
		'asu' => 'string',
		'des' => 'string',
		'urlpdf' => 'string',
		'res' => 'string',
		'idusu' => 'int',
		'codesttic' => 'int',
		'codpritic' => 'int',
		'codres' => 'int'
	];

	protected $fillable = [
		'cod',
		'feccre',
		'fecpro',
		'feccie',
		'asu',
		'des',
		'urlpdf',
		'res',
		'idusu',
		'codesttic',
		'codpritic',
		'codres'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'idusu', 'cod');
	}
	public function estado_ticket()
	{
		return $this->belongsTo(EstadoTicket::class, 'codesttic', 'cod');
	}
	public function prioridad_ticket()
	{
		return $this->belongsTo(PrioridadTicket::class, 'codpritic', 'cod');
	}
	public function reserva()
	{
		return $this->hasOne(Reserva::class, 'cod', 'codres');
	}
}