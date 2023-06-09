<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = false;
    protected $table = 'messages';

    protected $fillable = [
        'chatId',
        'from',
        'to',
        'message'
    ];

    public function sender(){
        return $this->belongsTo(User::class, 'from');
    }

    public function files(){
        return $this->hasMany(MessageFile::class, 'messageId', 'id');
    }
}
