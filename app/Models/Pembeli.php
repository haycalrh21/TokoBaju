<?php
// Pembeli.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembeli extends Model
{
    protected $table = 'pembelis';
    protected $fillable = [
        'namalengkap',
        'email',
        'alamat',
        'origin',
        'destination',
        'kodepos',
        'courier',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pembelians()
    {
        return $this->hasMany(Pembelian::class, 'pembeli_id');
    }

    public function keranjangs()
    {
        return $this->hasMany(Keranjang::class, 'pembeli_id', 'id');
    }
}
