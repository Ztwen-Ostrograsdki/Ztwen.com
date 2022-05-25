<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\DateFormattor;
use App\Helpers\ActionsTraits\ModelActionTrait;

class Chat extends Model
{
    use HasFactory;
    use SoftDeletes;
    use DateFormattor;
    use ModelActionTrait;
    protected $fillable = ['message', 'sender_id', 'receiver_id', 'seen', 'reply_to_id'];

    public function sender()
    {
        // 
    }

    public function receiver()
    {
        // 
    }

    public function getDateAgoFormated()
    {
        $this->__setDateAgo();
        return $this->dateAgoToStringForUpdated;
    }




}
