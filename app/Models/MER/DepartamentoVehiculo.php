<?php

namespace App\Models\MER;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DepartamentoVehiculo extends Model
{
    protected $table = 'departamento_vehiculo';
    protected $primaryKey = 'coddepveh';
    public $timestamps = false;

    protected $fillable = [
        'nomdepveh',
    ];

    public function ciudades(): HasMany
    {
        return $this->hasMany(CiudadVehiculo::class, 'coddepveh', 'coddepveh');
    }
}
