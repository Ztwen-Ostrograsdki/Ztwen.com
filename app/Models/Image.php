<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;
    const DEFAULT_PROFIL_PHOTO_PATH = "/myassets/images/product_02.jpg";

    protected $fillable = [
        'name',
    ];

    public function user()
    {
        return $this->morphedByMany(User::class, 'imageable');
    }

    public function product()
    {
        return $this->morphedByMany(Product::class, 'imageable');
    }

    public function category()
    {
        return $this->morphedByMany(Category::class, 'imageable');
    }

}
