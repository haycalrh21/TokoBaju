<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    protected $fillable = [
        'message_id',
        'content',
        'is_admin_reply',
    ];

    public function message()
    {
        return $this->belongsTo(Message::class);
    }
}
