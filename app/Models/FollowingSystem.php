<?php

namespace App\Models;

use App\Helpers\DateFormattor;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\ActionsTraits\ModelActionTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FollowingSystem extends Model
{
    use HasFactory;
    use DateFormattor;
    use ModelActionTrait;
    protected $fillable = ['followed_id', 'follower_id', 'accepted'];


    public function getDateAgoFormated($created_at = false)
    {
        $this->__setDateAgo();
        if($created_at){
            return $this->dateAgoToString;
        }
        return $this->dateAgoToStringForUpdated;
    }



    
}
