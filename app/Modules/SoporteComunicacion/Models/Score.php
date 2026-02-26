<?php

namespace App\Modules\SoporteComunicacion\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MER\Ticket;
use App\Modules\SoporteComunicacion\Models\Question;

class Score extends Model
{
    protected $table = 'scores';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    protected $casts = [
        'id' => 'int',
        'codtic' => 'string',
        'idques' => 'int',
        'score' => 'int'
    ];

    protected $fillable = [
        'codtic',
        'idques',
        'score'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'codtic', 'cod');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'idques', 'id');
    }
}
