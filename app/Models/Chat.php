<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $table = 'chats';

    protected $fillable = [
        'type',
    ];

    public function messages(){
        return $this->hasMany(Message::class, 'chatId', 'id');
    }

    public function users(){
        return $this->belongsToMany(User::class, 'chat_users', 'chatId','userId');
    }

}
