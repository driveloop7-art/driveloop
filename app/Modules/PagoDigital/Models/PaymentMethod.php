<?php

namespace App\Modules\PagoDigital\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $table = 'payment_methods';

    protected $fillable = ['name', 'label'];
}
