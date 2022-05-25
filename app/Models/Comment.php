<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use App\Helpers\DateFormattor;
use App\Models\MyNotifications;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\ActionsTraits\ModelActionTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;
    use DateFormattor;
    use ModelActionTrait;
    protected $fillable = [
        'content',
        'user_id',
        'product_id',
        'blocked',
        'approved',
    ];

    public function user()
    {
        return $this->BelongsTo(User::class);
    }
    public function product()
    {
        return $this->BelongsTo(Product::class);
    }
    
    public function myNotifications()
    {
        return $this->BelongsTo(MyNotifications::class);
    }

    public function getDateAgoFormated()
    {
        $this->__setDateAgo();
        return $this->dateAgoToStringForUpdated;
    }

}
