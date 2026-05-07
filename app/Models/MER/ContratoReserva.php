<?php

namespace App\Models\MER;

use Illuminate\Database\Eloquent\Model;

class ContratoReserva extends Model
{
    protected $table = 'contratos_reserva';

    protected $fillable = [
        'codres',
        'numero_contrato',
        'pdf_path',
        'fecha_emision',
        'estado',
    ];

    protected $casts = [
        'fecha_emision' => 'datetime',
    ];

    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'codres', 'cod');
    }
}