<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Cart extends Component
{
    public $products;
    public $user;
    public $carts;
    protected $listeners = ['myCartWasUpdated'];

    public function mount()
    {
        $user = Auth::user();
        if($user){
            $this->user = $user;
            $this->getUserCart();
            $this->products = $this->carts;
        }
    }

    public function getUserCart()
    {
        $this->carts = [];
        $carts = $this->user->shoppingBags->pluck('product_id')->toArray();
        if(count($carts) > 0){
            $this->carts = Product::whereIn('id', $carts)->get();
        }
    }

    public function render()
    {
        return view('livewire.cart');
    }


    public function getProducts()
    {
        $this->products = Product::all();
    }


    public function addToCart($product_id)
    {
        $product = Product::find($product_id);
        if($product && $this->user){
            if($this->user->addToCart($product->id)){
                $this->dispatchBrowserEvent('FireAlert', ['title' => 'Réussie', 'message' => "vous avez ajouté l'article {$product->getName()} à votre panier", 'type' => 'success']);
            }
            else{
                return abort(403, "Votre requête ne peut aboutir");
            }
        }
        $this->mount($this->user->id);
    }

    public function deleteFromCart($product_id)
    {
        $product = Product::find($product_id);
        if($product && $this->user){
            if($this->user->deleteFromCart($product->id)){
                $this->emit('myCartWasUpdated');
                $this->dispatchBrowserEvent('FireAlert', ['title' => 'Réussie', 'message' => "L'article {$product->getName()} a été retiré de votre panier", 'type' => 'success']);
            }
            else{
                return abort(403, "Votre requête ne peut aboutir");
            }
        }
    }

    public function updategalery($product_id)
    {
        $product = Product::find($product_id);
        if($product){
            $this->emit('targetedProduct', $product->id);
            $this->dispatchBrowserEvent('modal-updateProductGalery');
        }
    }

    public function editAProduct($product_id)
    {
        $product = Product::find($product_id);
        if($product){
            $this->emit('editAProduct', $product->id);
            $this->dispatchBrowserEvent('modal-editProduct');
        }
    }

    public function liked($product_id)
    {
        $product = Product::find($product_id);
        if($product && $this->user){
            if($this->user->likedThis('product', $product->id, $this->user->id)){
                $this->getUserCart();
            }
        }
        else{
            return abort(403, "Votre requête ne peut aboutir");
        }
    }

    public function myCartWasUpdated()
    {
        $this->mount();
    }
}
