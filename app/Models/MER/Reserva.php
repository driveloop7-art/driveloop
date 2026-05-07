<?php

namespace App\Models\MER;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Reserva
 * 
 * @property int $cod
 * @property Carbon $fecrea
 * @property Carbon $fecini
 * @property Carbon $fecfin
 * @property float|null $val
 * @property int $idusu
 * @property int $codveh
 * @property int $codestres
 * 
 * @property EstadoReserva $estado_reserva
 * @property User $user
 * @property Vehiculo $vehiculo
 * @property Collection|Calificacion[] $calificaciones
 * @property Collection|Cancelacion[] $cancelaciones
 * @property Collection|PolizaServicio[] $polizas_servicios
 * @property Collection|Resena[] $resenas
 *
 * @package App\Models\MER
 */
class Reserva extends Model
{
	protected $table = 'reservas';
	protected $primaryKey = 'cod';
	public $timestamps = false;


	protected $casts = [
		'fecrea' => 'datetime',
		'fecini' => 'datetime',
		'fecfin' => 'datetime',
		'fecha_cierre_real' => 'datetime',
		'val' => 'float',
		'codusu' => 'int',
		'codveh' => 'int',
		'codestres' => 'int',
		'confirmado_propietario' => 'boolean',
		'recibido_buen_estado' => 'boolean'
	];

	protected $fillable = [
		'fecrea',
		'fecini',
		'fecfin',
		'val',
		'idusu',
		'codveh',
		'codestres',
		'fecha_cierre_real',
		'confirmado_propietario',
		'recibido_buen_estado',
		'observacion_recepcion'
	];

	public function estado_reserva()
	{
		return $this->belongsTo(EstadoReserva::class, 'codestres');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'idusu', 'id');
	}

	public function vehiculo()
	{
		return $this->belongsTo(Vehiculo::class, 'codveh');
	}

	public function calificaciones()
	{
		return $this->hasMany(Calificacion::class, 'codres');
	}

	public function cancelaciones()
	{
		return $this->hasMany(Cancelacion::class, 'codres');
	}

	public function polizas_servicios()
	{
		return $this->hasMany(PolizaServicio::class, 'codres');
	}

	public function resenas()
	{
		return $this->hasMany(Resena::class, 'codres');
	}

	public function pagos()
	{
		return $this->hasMany(Pago::class, 'codres', 'cod');
	}

	public function pago()
	{
		return $this->hasOne(Pago::class, 'codres', 'cod');
	}
	public function contrato()
	{
		return $this->hasOne(ContratoReserva::class, 'codres', 'cod');
	}
	public function polizaServicio()
	{
		return $this->hasOne(PolizaServicio::class, 'codres', 'cod');
	}
}
