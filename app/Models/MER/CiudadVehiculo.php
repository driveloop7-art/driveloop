<?php

namespace App\Models\MER;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CiudadVehiculo extends Model
{
    protected $table = 'ciudad_vehiculo';
    protected $primaryKey = 'codciuveh';
    public $timestamps = false;

    protected $fillable = [
        'coddepveh',
        'nomciuveh',
    ];

    public function departamento(): BelongsTo
    {
        return $this->belongsTo(DepartamentoVehiculo::class, 'coddepveh', 'coddepveh');
    }
}
