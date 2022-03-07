<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Photo extends Model
{
    const DEFAULT_PROFIL_PHOTO_PATH = "/myassets/images/product_02.jpg";

    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'user_id',
    ];

    public function user()
    {
        return $this->BelongsTo(User::class);
    }
}
