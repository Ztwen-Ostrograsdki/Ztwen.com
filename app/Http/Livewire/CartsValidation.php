<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CartsValidation extends Component
{

    public $quantities = [];

    public function mount(int $user_id)
    {
        $quantities = [];
        $carts = Auth::user()->shoppingBags;
        foreach($carts as $cart){
            $quantities[$cart->product_id] = $cart->quantity;
        }
        $this->quantities = $quantities;
    }

    public function render()
    {
        $carts = $this->getUserCart();
        return view('livewire.carts-validation', compact('carts'));
    }

    public function getAmountProperty()
    {
        $amount = 0;
        foreach($this->quantities as $product_id => $q){
            $prod_amount = 0;
            $product = Product::find($product_id);
            if($product){
                $prod_amount = $product->price * (int)$q;
            }
            $amount += $prod_amount;
        }

        return $amount;
    }

    public function getUserCart()
    {
        $carts = [];
        $data = Auth::user()->shoppingBags;
        if(count($data) > 0){
            foreach($data as $shop){
                $product = Product::find($shop->product_id);
                if($product){
                    $carts[] = $product;
                }
            }
        }
        return $carts;
    }


    public function retrieve($product_id)
    {
        $p = Product::find($product_id);
        if($p){
            $product = $p;
        }
        else{
            $this->dispatchBrowserEvent('Toast', ['title' => 'Article inconnue', 'message' => "L'article que vous tenter de retirer de votre panier est introuvable ou a été déjà retiré!", 'type' => 'warning']);
        }
        if($product){
            $del = $product->__retrieveFromUserCart();
            if($del){
                $this->dispatchBrowserEvent('Toast', ['title' => 'Suppression réussie', 'message' => "L'article {$product->getName()} a été retiré de votre panier avec succès!", 'type' => 'success']);
            }
            else{
                $this->dispatchBrowserEvent($product->livewire_product_alert_type, $product->livewire_product_errors);
            }
        }
    }





}
