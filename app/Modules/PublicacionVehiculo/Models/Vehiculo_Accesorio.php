<?php

namespace App\Modules\PublicacionVehiculo\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MER\Vehiculo;

/**
 * Class Accesorio
 * 
 * @property int $codveh
 * @property string $idacc
 *
 * @property Collection|Vehiculo[] $vehiculos
 * @property Collection|Accesorio[] $accesorios
 * 
 * @package App\Modules\PublicacionVehiculo\Models
 */

class Vehiculo_Accesorio extends Model
{
    protected $table = 'vehiculos_accesorios';
	protected $primaryKey = 'codveh';
	public $timestamps = false;

    protected $casts = [
        'codveh' => 'int',
        'idacc' => 'int'
    ];

	protected $fillable = [
		'codveh',
		'idacc'
    ];

    public function vehiculos()
	{
		return $this->hasMany(Vehiculo::class, 'codveh');
	}

    public function accesorios()
	{
		return $this->hasMany(Accesorio::class, 'idacc');
	}
}
