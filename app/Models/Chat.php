<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['message', 'sender_id', 'receiver_id', 'seen', 'reply_to_id'];

    public function sender()
    {
        // 
    }

    public function receiver()
    {
        // 
    }




}
