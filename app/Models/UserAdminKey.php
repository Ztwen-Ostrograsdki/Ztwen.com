<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserAdminKey extends Model
{
    use HasFactory;
    protected $fillable = ['key', 'user_id', 'advanced'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }



}
