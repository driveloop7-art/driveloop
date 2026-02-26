<?php

namespace App\Modules\SoporteComunicacion\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    protected $casts = [
        'id' => 'int',
        'question' => 'string',
        'is_active' => 'boolean'
    ];
}