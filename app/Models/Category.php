<?php

namespace App\Models;

use App\Models\Product;
use App\Helpers\DateFormattor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\ActionsTraits\ModelActionTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    use DateFormattor;
    use ModelActionTrait;

    protected $fillable = ['name', 'description'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }


    public function getDateAgoFormated()
    {
        $this->__setDateAgo();
        return $this->dateAgoToStringForUpdated;
    }


}
