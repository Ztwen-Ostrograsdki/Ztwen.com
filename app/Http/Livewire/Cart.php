<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class Cart extends Component
{
    public $products;
    public $allProductsComments = [];
    public function render()
    {
        return view('livewire.cart');
    }


    public function getProducts()
    {
        $allProducts = Product::all();

        $this->products = $allProducts;
        foreach($this->products as $p){
            $this->product->productGalery();
            $this->product->__setDateAgo();
            $this->allProductsComments[$p->id] = $p->comments;
        }
        
    }
}
