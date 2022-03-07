<?php

namespace App\Models;

use App\Helpers\DateFormattor;
use App\Models\User;
use App\Models\Image;
use App\Models\Comment;
use App\Models\SeenLikeProductSytem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    use DateFormattor;

    public $myLikes;
    const MAX_IMAGES = 3;
    const DEFAULT_PRODUCT_GALERY_PATH = ["/myassets/default/default-img-product.jpg", "/myassets/default/default-img-product.jpg", "/myassets/default/default-img-product.jpg",];

    protected $fillable = [
        'slug',
        'description',
        'price',
        'total',
        'bought',
        'total',
        'sells',
        'seen',
        'user_id'
    ];


    public function getName()
    {
        return str_replace('-', ' ', $this->slug);
    }
    
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(SeenLikeProductSytem::class);
    }

    public function productGalery()
    {
        if($this->images->count() < 1){
            return self::DEFAULT_PRODUCT_GALERY_PATH;
        }
        else{
            return $this->images;
        }
    }

}
