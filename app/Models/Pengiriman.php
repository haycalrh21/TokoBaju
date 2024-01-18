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
        'alamat',
        'user_id',
        'kota_asal',
        'kota_tujuan',
        'hargaongkir',
        'service',
        'estimasi_hari',

    ];

    // Definisikan relasi dengan check_out jika diperlukan
    public function checkout()
    {
        return $this->hasMany(CheckOut::class,'user_id');
    }

    // Definisikan relasi dengan user jika diperlukan
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
