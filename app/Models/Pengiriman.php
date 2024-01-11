<?php

// app/Models/Pengiriman.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'user_id',
        'kota_asal',
        'kota_tujuan',
        'harga',
        'service',
        'estimasi_hari',

    ];

    // Definisikan relasi dengan check_out jika diperlukan
    public function checkOut()
    {
        return $this->belongsTo(CheckOut::class);
    }

    // Definisikan relasi dengan user jika diperlukan
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
