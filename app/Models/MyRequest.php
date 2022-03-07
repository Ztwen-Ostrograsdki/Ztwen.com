<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class MyRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'target_id',
        'request_object',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
