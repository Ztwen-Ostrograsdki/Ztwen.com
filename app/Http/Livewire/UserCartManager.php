<?php

namespace App\Http\Livewire;

use App\Models\ShoppingBag;
use Livewire\Component;

class UserCartManager extends Component
{
    protected $listeners = ['openUserCartManager'];

    public $cart;
    public $user;
    public $product;

    public function render()
    {
        return view('livewire.user-cart-manager');
    }


    public function openUserCartManager($cart_id)
    {   
        $this->getCart($cart_id);
    }


    public function getCart($cart_id)
    {
        $cart = ShoppingBag::find($cart_id);
        if($cart){
            $this->cart = $cart;
            $this->product = $this->cart->product;
            $this->user = $this->cart->user;
            $this->dispatchBrowserEvent('modal-userCartManager');
        }
    }
}
