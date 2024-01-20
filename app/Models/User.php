<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'nohp',
        'alamat',

    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function keranjangs()
    {
        return $this->hasMany(Keranjang::class, 'user_id'); // 'user_id' harus menjadi foreign key di model 'Keranjang'
    }
    public function pembelians()
    {
        return $this->hasMany(Pembelian::class, 'user_id');
    }
    public function checkOuts()
    {
        return $this->hasMany(CheckOut::class);
    }

    public function cart()
{
    return $this->hasOne(Cart::class);
}

public function messages(){
    return $this->hasMany(Messages::class);
}
}
