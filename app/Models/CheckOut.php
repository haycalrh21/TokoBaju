<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckOut extends Model
{
    use HasFactory;
    protected $fillable = [
       'cart_id', 'user_id', 'product_id', 'size', 'quantity', 'harga','totalPrice',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
