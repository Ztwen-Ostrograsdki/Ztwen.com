<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'content',
        'user_id',
        'product_id'
    ];

    public function user()
    {
        return $this->BelongsTo(User::class);
    }
    public function product()
    {
        return $this->BelongsTo(Product::class);
    }

}
