<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reported extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'reporter_id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
