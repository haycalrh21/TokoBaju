<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckOut extends Model
{
    use HasFactory;

    protected $fillable = [
       'cart_id', 'user_id', 'product_id', 'size', 'quantity', 'harga', 'totalPrice','namabarang','jenisbarang'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pengiriman()
    {
        return $this->belongsTo(Pengiriman::class, 'cart_id', 'cart_id');
    }
}
