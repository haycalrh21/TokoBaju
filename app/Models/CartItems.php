<?php

namespace App\Models;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartItems extends Model
{
    use HasFactory;

    protected $fillable = ['cart_id', 'product_id', 'size', 'quantity','harga'];

    public function cart(){
        return $this->belongsTo(Cart::class);

    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function product_size()
    {
        return $this->belongsTo(ProductSize::class);
    }

}
