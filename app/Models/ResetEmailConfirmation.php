<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResetEmailConfirmation extends Model
{
    use HasFactory;
    protected $fillable = [
        'new_email',
        'user_id',
        'token',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
