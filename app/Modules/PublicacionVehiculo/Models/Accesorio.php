<?php

namespace App\Modules\PublicacionVehiculo\Models;

use App\Models\MER\Vehiculo;
use Illuminate\Database\Eloquent\Model;


class Accesorio extends Model
{
	protected $table = 'accesorios';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $casts = [
		'id' => 'int'
	];

	protected $fillable = [
		'des'
	];
	public function vehiculos()
	{
		return $this->belongsToMany(
			Vehiculo::class,
			'vehiculos_accesorios',
			'idacc',   // FK en pivote que apunta a accesorios
			'codveh',  // FK en pivote que apunta a vehiculos
			'id',      // PK local en accesorios
			'cod'      // PK local en vehiculos
		);
	}
}
