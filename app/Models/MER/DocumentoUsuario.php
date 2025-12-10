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
		'codusu'
	];

	public function tipo_doc_usuario()
	{
		return $this->belongsTo(TipoDocUsuario::class, 'idtipdocusu');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'codusu', 'cod');
	}
}
