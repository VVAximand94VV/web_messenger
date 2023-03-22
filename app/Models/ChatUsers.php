<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatUsers extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = false;
    protected $table = 'chat_users';

}
