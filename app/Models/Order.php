<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['id','cart_id','user_id','product_id','namabarang','size','jenisbarang','alamat','kota_tujuan','hargaongkir','service','estimasi_hari','quantity','harga','totalPrice','status'];

    public function CheckOut(){
        return $this->belongsTo(CheckOut::class);
    }

    public function pengiriman(){
        return $this->belongsTo(Pengiriman::class);
    }

}
