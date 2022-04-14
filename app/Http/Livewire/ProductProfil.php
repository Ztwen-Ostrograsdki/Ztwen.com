<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Models\ShoppingBag;
use App\Models\SeenLikeProductSytem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class ProductProfil extends Component
{

    protected $listeners = ['connected', 'targetedProduct', 'resetTargetedProduct', 'productUpdated', 'updatingFinish'];
    public $galery;
    public $product;
    public $product_category;
    public $updating = false;

    public function mount()
    {
        $id = (int)request()->id;
        if($id){
            $product = Product::find($id);
            if($product){
                $this->product = $product;
                $this->product_category = $this->product->category;
                $this->galery = $this->product->productGalery();
                $this->emit('targetedProduct', $this->product->id);
                $this->product->__setDateAgo();
            }
            else{
                return abort(403, "Votre requête ne peut aboutir désolé");
            }
        }
    }

    public function getProduct()
    {
        $this->mount();
        $this->product_category = $this->product->category;
    }


    public function resetTargetedProduct()
    {
        $this->reset('product');
    }

    public function targetedProduct($p)
    {
        $product = Product::find($p);
        $this->product = $product;
        $this->galery = $this->product->productGalery();
        $this->product->__setDateAgo();
    }

    
    public function render()
    {
        return view('livewire.product-profil');
    }

    public function booted()
    {
        // $this->product->__setDateAgo();
    }




    public function liked()
    {
        $user = Auth::user();
        $product = $this->product;
        if($product){
            $seen = $product->seen;
            if($user){
                $product->update(['seen' => $seen + 1]);
                SeenLikeProductSytem::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'reaction' => true,
                ]);
            }
            else{
                $product->update(['seen' => $seen + 1]);
                SeenLikeProductSytem::create([
                    'product_id' => $product->id,
                    'reaction' => true,
                ]);
            }
        }
        else{
            return abort(403, "Votre requête ne peut aboutir");
        }
        $this->product->__setDateAgo();
    }

    public function productUpdated($product_id)
    {
        $this->updating = true;
        $this->galery = [];
        $product = Product::find($product_id);
        if($product){
            $this->emit('productUpdated', $product_id);
        }
    }

    public function updatingFinish($asset = true)
    {
        $this->updating = false;
        $this->getProduct();
    }


    public function updategalery()
    {
        $this->emit('targetedProduct', $this->product->id);
        $this->dispatchBrowserEvent('modal-updateProductGalery');
        
    }
    public function editAProduct()
    {
        $this->emit('editAProduct', $this->product->id);
        $this->dispatchBrowserEvent('modal-editProduct');
        $this->getProduct();
    }


    public function bought()
    {

    }


    public function addToCart()
    {
        $product_id = $this->product->id;
        $user = Auth::user();

        if($user){
            $product = Product::find($product_id);
            if($product && !$user->alreadyIntoCart($product->id)){
                $panier = ShoppingBag::create(['user_id' => $user->id, 'product_id' => $product->id]);
                $this->emit('cartEdited', $user->id);
                $this->dispatchBrowserEvent('FireAlert', ['title' => false, 'message' => "vous avez ajouté l'article {$product->getName()} à votre panier", 'type' => 'success']);
            }
            else{
                return abort(403, "Votre requête ne peut aboutir");
            }

        }
        else{
            return redirect(route('login'));
        }
        $this->getProduct();
    }
    public function deleteFromCart()
    {
        $product_id = $this->product->id;
        $user = Auth::user();
        if($user){
            $product = Product::find($product_id);
            if($product && $user->alreadyIntoCart($product->id)){
                $shop = ShoppingBag::where('user_id', $user->id)->where('product_id', $product->id);
                if($shop->get()->count() > 0){
                    $action  = $shop->first()->delete();
                    if($action){
                        $this->emit('cartEdited', $user->id);
                        $this->dispatchBrowserEvent('FireAlert', ['title' => false, 'message' => "L'article {$product->getName()} a été retiré de votre panier", 'type' => 'success']);
                    }
                }
            }
            else{
                return abort(403, "Votre requête ne peut aboutir");
            }
        }
        else{
            return redirect(route('login'));
        }
        $this->getProduct();
    }


    public function connected($user_id)
    {
        $this->getProduct();
    }

}
