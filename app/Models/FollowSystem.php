<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowSystem extends Model
{
    use HasFactory;
    protected $fillable = ['followed_id', 'follower_id'];
}