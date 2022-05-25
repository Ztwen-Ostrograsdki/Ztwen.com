<?php

namespace App\Models;

use App\Models\User;
use App\Models\Comment;
use App\Helpers\DateFormattor;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\ActionsTraits\ModelActionTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MyNotifications extends Model
{
    use HasFactory;
    use DateFormattor;
    use ModelActionTrait;
    protected $fillable = ['content', 'user_id', 'seen', 'target', 'target_id', 'comment_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function comment()
    {
        return $this->belongsTo(Comment::class);
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
