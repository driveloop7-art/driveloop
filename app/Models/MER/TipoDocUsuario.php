<?php

namespace App\Models\MER;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TipoDocUsuario
 * 
 * @property int $id
 * @property string $nom
 * @property string $des
 * 
 * @property Collection|DocumentoUsuario[] $documentos_usuarios
 *
 * @package App\Models
 */
class TipoDocUsuario extends Model
{
	protected $table = 'tipos_doc_usuario';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int'
	];

	protected $fillable = [
		'nom',
		'des'
	];

	public function documentos_usuarios()
	{
		return $this->hasMany(DocumentoUsuario::class, 'idtipdocusu');
	}
}
