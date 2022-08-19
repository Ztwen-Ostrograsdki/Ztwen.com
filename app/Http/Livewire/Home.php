<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Models\Product;
use Livewire\Component;

class Home extends Component
{
    protected $listeners = [];

    public function render()
    {
        $lastComments = Comment::where('blocked', 0)->where('approved', 1)->orderBy('created_at', 'desc')->get()->count();
        return view('livewire.home', compact('lastComments'));

    }

}
