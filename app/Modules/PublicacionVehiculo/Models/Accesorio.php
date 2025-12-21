<?php

namespace App\Modules\PublicacionVehiculo\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Accesorio
 * 
 * @property int $id
 * @property string $des
 * 
 * @package App\Modules\PublicacionVehiculo\Models
 */

class Accesorio extends Model
{
    protected $table = 'accesorios';
	protected $primaryKey = 'id';
	public $timestamps = false;

    protected $casts = [
        'des' => 'string|max:80'
    ];

	protected $fillable = [
		'des'
    ];
}
