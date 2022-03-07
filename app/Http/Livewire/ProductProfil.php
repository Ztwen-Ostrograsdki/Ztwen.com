<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Models\SeenLikeProductSytem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class ProductProfil extends Component
{

    public $name = "salut les gens";
    protected $listeners = ['targetedProduct', 'resetTargetedProduct', 'productUpdated'];
    public $galery;
    public $product;

    public function mount()
    {
        if(Route::currentRouteName() == 'product-profil'){
            $id = (int)request()->id;
            if($id){
                $product = Product::find($id);
                if($product){
                    $this->product = $product;
                }
                else{
                    return abort(403, "Votre requête ne peut aboutir désolé");
                }
            }
        }

        if($this->product){
            $this->product->myLikes = $this->product->likes->count();
            $this->product->__setDateAgo();
            $this->galery = $this->product->productGalery();
            $this->emit('targetedProduct', $this->product->id);
        }
        
    }

    public function getProduct()
    {
        $this->mount();
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
    }

    
    public function render()
    {
        return view('livewire.product-profil');
    }

    public function booted()
    {
        // return $this->mount();
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

        $this->productUpdated($product->id);

    }

    public function productUpdated($product_id)
    {
        $product = Product::find($product_id);
        if($product){
            $this->mount();
            $this->emit('productUpdated', $product_id);
        }
    }


    public function updategalery()
    {
        $this->emit('targetedProduct', $this->product->id);
        // $this->dispatchBrowserEvent('hide-form');
        $this->dispatchBrowserEvent('modal-updateProductGalery');
        
    }

}
