<?php
// app/Product.php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'namabarang',
        'jenisbarang',
        'brand',
        'harga',
        'image',
        'stok' ,// Kolom untuk menyimpan data ukuran dan stok dalam format JSON

        'ukuran' // Kolom untuk menyimpan data ukuran dan stok dalam format JSON
    ];
    public function productSizes()
    {
        return $this->hasMany(ProductSize::class, 'product_id');
    }

    public function sizes(){
        return $this->hasMany(ProductSize::class, 'product_id');
    }


}

