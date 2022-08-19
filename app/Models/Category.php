<?php

namespace App\Models;

use App\Models\Product;
use App\Helpers\DateFormattor;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\ZtwenManagers\GaleryManager;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\ActionsTraits\ModelActionTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    use DateFormattor;
    use ModelActionTrait;
    use GaleryManager;

    protected $fillable = ['name', 'description'];
    public $imagesFolder = 'categoriesImages';

    public function getSlug()
    {
        return str_replace(' ', '-', $this->name);
    }

    public function hasProducts()
    {
        return $this->products->count() > 0;
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function images()
    {
        return $this->morphToMany(Image::class, 'imageable');
    }


    public function getDateAgoFormated()
    {
        $this->__setDateAgo();
        return $this->dateAgoToStringForUpdated;
    }


}
