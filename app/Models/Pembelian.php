<?php

// Pembelian.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $table = 'pembelians';
    protected $fillable = ['pembeli_id'];

    public function pembeli()
    {
        return $this->belongsTo(Pembeli::class, 'pembeli_id');
    }

    public function keranjangs()
    {
        return $this->hasMany(Keranjang::class, 'pembelian_id', 'id');
    }
}
