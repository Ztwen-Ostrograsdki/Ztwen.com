<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Header extends Component
{
    protected $listeners = ['newUserConnected', 'targetedProduct'];
    public $user;
    public $username;
    public function render()
    {
        return view('livewire.header');
    }

    public function newUserConnected()
    {
        return $this->user = Auth::user();
    }


    public function targetedProduct($p)
    {
        
    }
}
