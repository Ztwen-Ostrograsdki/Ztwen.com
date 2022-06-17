<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class ProductImagesGalery extends Component
{
    public $product;

    protected $listeners = ['loadProductImages'];

    public function render()
    {
        return view('livewire.product-images-galery');
    }


    public function loadProductImages($product_id)
    {
        $product = Product::find($product_id);
        if($product){
            $this->product = $product;
        }
        else{
            return abort(404);
        }
    }
}
