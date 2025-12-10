<?php

namespace App\Models\MER;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TipoDocVehiculo
 * 
 * @property int $id
 * @property string $nom
 * @property string $des
 * 
 * @property Collection|DocumentoVehiculo[] $documentos_vehiculos
 *
 * @package App\Models
 */
class TipoDocVehiculo extends Model
{
	protected $table = 'tipos_doc_vehiculo';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int'
	];

	protected $fillable = [
		'nom',
		'des'
	];

	public function documentos_vehiculos()
	{
		return $this->hasMany(DocumentoVehiculo::class, 'idtipdocveh');
	}
}
