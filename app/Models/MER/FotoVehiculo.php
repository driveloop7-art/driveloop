<?php

namespace App\Models\MER;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class FotoVehiculo extends Model
{
    protected $table = 'fotos_vehiculo';
    protected $primaryKey = 'cod';
    public $timestamps = false;

    protected $fillable = [
        'nom',
        'ruta',
        'dim',
        'mim',
        'pes',
        'codveh',
    ];

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'codveh');
    }


	// Se realiza cambio en este modelo con el fin de optimizar la presentacion de las imagenes y permitir 
	// que se pueda usar en cualquier vista con blade usando sintaxis simple como {{ $foto->url }}


    public function getUrlAttribute(): string
    {
        if (!$this->ruta) {
            return asset('img/no-image.jpg');
        }

        if (str_starts_with($this->ruta, 'http://') || str_starts_with($this->ruta, 'https://')) {
            return $this->ruta;
        }

        $ruta = ltrim($this->ruta, '/');

        return Storage::disk('public')->url($ruta);
    }
}