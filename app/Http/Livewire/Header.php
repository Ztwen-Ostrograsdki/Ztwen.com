<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Header extends Component
{
    protected $listeners = ['newUserConnected', 'targetedProduct', 'cartEdited'];
    public $user;
    public $username;
    public $carts;


    public function mount()
    {
        $this->getUserData();
    }
    public function render()
    {
        return view('livewire.header');
    }


    public function booted()
    {
        $this->getUserData();
    }

    public function newUserConnected()
    {
        return $this->user = Auth::user();
    }


    public function getUserData()
    {
        $user = Auth::user();
        if($user){
            $this->carts = $user->shoppingBags()->count();
        }
    }

    public function cartEdited($user_id)
    {
        if(Auth::user() && $user_id == Auth::user()->id){
            $this->getUserData();
        }
    }

    public function targetedProduct($p)
    {
        
    }

    public function createNewProduct()
    {
        $this->emit('createAProduct');
    }
}
