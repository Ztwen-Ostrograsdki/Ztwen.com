<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Models\SeenLikeProductSytem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class ProductProfil extends Component
{

    protected $listeners = ['targetedProduct', 'resetTargetedProduct', 'productUpdated', 'updatingFinish'];
    public $galery;
    public $product;
    public $updating = false;

    public function mount()
    {
        if(Route::currentRouteName() == 'product-profil'){
            $id = (int)request()->id;
            if($id){
                $product = Product::find($id);
                if($product){
                    $this->product = $product;
                    $this->product->__setDateAgo();
                }
                else{
                    return abort(403, "Votre requête ne peut aboutir désolé");
                }
            }
        }

        if($this->product){
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
        $this->product->__setDateAgo();
    }

    
    public function render()
    {
        return view('livewire.product-profil');
    }

    // public function booted()
    // {
    //     // $this->product->__setDateAgo();
    // }




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

}
