<?php
// Keranjang.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $table = 'keranjangs';

    protected $fillable = [
        'namabarang',
        'brand',
        'ukuran',
        'jumlahbarang',
        'harga',
        'total_harga',
        'pembelian_id',
        'user_id',
        'status_pembayaran'
    ];

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'pembelian_id');
    }
    public function productSizes()
    {
        return $this->hasMany(ProductSize::class);
    }
}
