<?php

namespace App\Models\MER;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 * 
 * @property int $cod
 * @property string $des
 * 
 * @property Collection|User[] $users
 *
 * @package App\Models\MER
 */
class Role extends Model
{
	protected $table = 'roles';
	protected $primaryKey = 'cod';
	public $timestamps = false;

	protected $fillable = [
		'des'
	];

	public function users()
	{
		return $this->hasMany(User::class, 'codrol');
	}
}
