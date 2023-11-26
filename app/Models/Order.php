<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $table = 'orders';

    protected $fillable = [
        'full-name',
        'email',
        'alamat',
        'provinsi',
        'kodepos',
        'pengiriman',
    ];
}
