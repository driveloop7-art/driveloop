<?php

namespace App\Models\MER;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DocumentoVehiculo
 * 
 * @property int $id
 * @property int $idtipdocveh
 * @property string $numdoc
 * @property string $empexp
 * @property string $descdoc
 * @property int|null $codveh
 * 
 * @property TipoDocVehiculo $tipo_doc_vehiculo
 * @property Vehiculo|null $vehiculo
 *
 * @package App\Models\MER
 */
class DocumentoVehiculo extends Model
{
	// protected $table = 'documentos_vehiculo';
	// public $incrementing = false;
	// public $timestamps = false;

	// protected $casts = [
	// 	'id' => 'int',
	// 	'idtipdocveh' => 'int',
	// 	'codveh' => 'int'
	// ];

	// protected $fillable = [
	// 	'idtipdocveh',
	// 	'numdoc',
	// 	'empexp',
	// 	'descdoc',
	// 	'codveh'
	// ];

	protected $table = 'documentos_vehiculo';
    protected $primaryKey = 'id';
    public $incrementing = true; 
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'idtipdocveh',
        'numdoc',
        'empexp',
        'descdoc',
        'codveh'
    ];
	

	public function tipo_doc_vehiculo()
	{
		return $this->belongsTo(TipoDocVehiculo::class, 'idtipdocveh');
	}

	public function vehiculo()
	{
		return $this->belongsTo(Vehiculo::class, 'codveh');
	}
}
