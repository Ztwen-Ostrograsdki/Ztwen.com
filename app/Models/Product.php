<?php

namespace App\Models;

use App\Models\User;
use App\Models\Image;
use App\Models\Comment;
use App\Models\Category;
use App\Models\ShoppingBag;
use App\Helpers\DateFormattor;
use App\Models\SeenLikeProductSytem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\ActionsTraits\ModelActionTrait;
use App\Helpers\ProductsTraits\ProductTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    use DateFormattor;
    use ModelActionTrait;
    use ProductTrait;

    public $myLikes;
    public $livewire_product_errors = [];
    public $livewire_product_alert_type = "FireAlertDoNotClose";
    const MAX_IMAGES = 3;
    const IMAGES_BASE_PATH = '/storage/articlesImages/';
    const DEFAULT_PRODUCT_GALERY_PATH = ["/myassets/default/default-img-product.jpg", "/myassets/default/default-img-product.jpg", "/myassets/default/default-img-product.jpg",];

    protected $fillable = [
        'slug',
        'description',
        'price',
        'total',
        'bought',
        'sells',
        'seen',
        'user_id',
        'reduction', 
        'category_id'
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


    public function mySeens()
    {
        return $this->seen;
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

    /**
     * Undocumented function
     *
     * @return 'path' of image
     */
    public function getRandomDefaultImage()
    {
        $r = rand(0, 2);
        if($this->images->count() < 1){
            return ($this->productGalery())[$r];
        }
        return self::IMAGES_BASE_PATH . $this->images->reverse()->first()->name;
    }

    public function getProductDefaultImageInGalery()
    {
        $galery = $this->productGalery();
        $size = $galery->count() - 1;
        $r = rand(0, $size);
        $images = [];
        foreach ($galery as $key => $image) {
            $images[] = $image;
        }
        return $images[$r]->name;
    }

    public function shoppingBags()
    {
        return $this->hasMany(ShoppingBag::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getDateAgoFormated($created_at = false)
    {
        $this->__setDateAgo();
        if($created_at){
            return $this->dateAgoToString;
        }
        return $this->dateAgoToStringForUpdated;
    }

    

}
