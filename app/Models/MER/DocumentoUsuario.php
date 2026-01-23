<?php

namespace App\Models\MER;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DocumentoUsuario
 * 
 * @property int $id
 * @property int $idtipdocusu
 * @property string $num
 * @property int|null $codusu
 * @property string|null $url_anverso
 * @property string|null $url_reverso
 * @property string|null $estado
 * @property string|null $mensaje_rechazo
 * 
 * @property TipoDocUsuario $tipo_doc_usuario
 * @property User|null $user
 *
 * @package App\Models\MER
 */
class DocumentoUsuario extends Model
{
	protected $table = 'documentos_usuario';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'idtipdocusu' => 'int',
		'codusu' => 'int'
	];

	protected $fillable = [
		'idtipdocusu',
		'num',
		'codusu',
		'url_anverso',
		'url_reverso',
		'estado',
		'mensaje_rechazo'
	];

	public function tipo_doc_usuario()
	{
		return $this->belongsTo(TipoDocUsuario::class, 'idtipdocusu');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'codusu', 'id');
	}
}
