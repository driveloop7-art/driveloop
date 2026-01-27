<?php

namespace App\Modules\PagoDigital\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentStatus extends Model
{
    protected $table = 'payment_statuses';

    protected $fillable = ['name', 'label'];
}
