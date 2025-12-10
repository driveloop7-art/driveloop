<?php

namespace App\Models\MER;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Vehiculo
 * 
 * @property int $cod
 * @property string $vin
 * @property Carbon $mod
 * @property string $col
 * @property int $pas
 * @property int|null $cil
 * @property int $codpol
 * @property int $codmar
 * @property int $codlin
 * @property int $codcla
 * @property int $codcom
 * 
 * @property Clase $clase
 * @property Combustible $combustible
 * @property Linea $linea
 * @property Marca $marca
 * @property PolizaVehiculo $poliza_vehiculo
 * @property Collection|DocumentoVehiculo[] $documentos_vehiculos
 * @property Collection|FotoVehiculo[] $fotos_vehiculos
 * @property Collection|Reserva[] $reservas
 *
 * @package App\Models\MER
 */
class Vehiculo extends Model
{
	protected $table = 'vehiculos';
	protected $primaryKey = 'cod';
	public $timestamps = false;

	protected $casts = [
		'mod' => 'datetime',
		'pas' => 'int',
		'cil' => 'int',
		'codpol' => 'int',
		'codmar' => 'int',
		'codlin' => 'int',
		'codcla' => 'int',
		'codcom' => 'int'
	];

	protected $fillable = [
		'vin',
		'mod',
		'col',
		'pas',
		'cil',
		'codpol',
		'codmar',
		'codlin',
		'codcla',
		'codcom'
	];

	public function clase()
	{
		return $this->belongsTo(Clase::class, 'codcla');
	}

	public function combustible()
	{
		return $this->belongsTo(Combustible::class, 'codcom');
	}

	public function linea()
	{
		return $this->belongsTo(Linea::class, 'codlin');
	}

	public function marca()
	{
		return $this->belongsTo(Marca::class, 'codmar');
	}

	public function poliza_vehiculo()
	{
		return $this->belongsTo(PolizaVehiculo::class, 'codpol');
	}

	public function documentos_vehiculos()
	{
		return $this->hasMany(DocumentoVehiculo::class, 'codveh');
	}

	public function fotos_vehiculos()
	{
		return $this->hasMany(FotoVehiculo::class, 'codveh');
	}

	public function reservas()
	{
		return $this->hasMany(Reserva::class, 'codveh');
	}
}
