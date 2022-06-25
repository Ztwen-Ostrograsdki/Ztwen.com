<?php

namespace App\Models;

use App\Helpers\DateFormattor;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShoppingBag extends Model
{
    use HasFactory;
    use DateFormattor;


    protected $fillable = ['user_id', 'product_id', 'quantity'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function product()
    {
        return $this->belongsTo(Product::class);
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
