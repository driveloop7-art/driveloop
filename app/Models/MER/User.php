<?php

namespace App\Models\MER;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 * 
 * @property int $id
 * @property int|null $cod
 * @property string $nom
 * @property string $ape
 * @property string $email
 * @property string|null $tel
 * @property Carbon|null $fecnac
 * @property string|null $lic
 * @property Carbon $fecreg
 * @property string|null $numcue
 * @property int $codrol
 * @property int|null $numdir
 * @property int|null $codciu
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Ciudad|null $ciudad
 * @property Direccion|null $direccion
 * @property Role $role
 * @property Collection|DocumentoUsuario[] $documentos_usuarios
 * @property Collection|Reserva[] $reservas
 * @property Collection|Ticket[] $tickets
 *
 * @package App\Models\MER
 */
class User extends Authenticatable
{
	/** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

	protected $table = 'users';
	
	/**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nom',
        'ape',
        'email',
        'tel',
        'fecnac',
        'lic',
        'numcue',
        'password',
    ];

	/**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
	protected $hidden = [
		'password',
		'remember_token'
	];

	/**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'fecnac' => 'date' //Tratar la fecha de nacimiento como un tipo date
        ];
    }

	public function ciudad()
	{
		return $this->belongsTo(Ciudad::class, 'codciu');
	}

	public function direccion()
	{
		return $this->belongsTo(Direccion::class, 'numdir');
	}

	public function role()
	{
		return $this->belongsTo(Role::class, 'codrol');
	}

	public function documentos_usuarios()
	{
		return $this->hasMany(DocumentoUsuario::class, 'codusu', 'cod');
	}

	public function reservas()
	{
		return $this->hasMany(Reserva::class, 'codusu', 'cod');
	}

	public function tickets()
	{
		return $this->hasMany(Ticket::class, 'codusu', 'cod');
	}
}
