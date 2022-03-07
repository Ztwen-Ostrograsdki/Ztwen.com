<?php

namespace App\Http\Livewire;

use App\Models\Image;
use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ProductEditor extends Component
{
    use WithFileUploads;
    public $product;
    public $product_image;
    public $product_image_name;
    protected $listeners = ['targetedProduct', 'resetTargetedProduct'];


    public function render()
    {
        return view('livewire.product-editor');
    }


    public function resetTargetedProduct()
    {
        
    }
    public function targetedProduct($product_id)
    {
        $product = Product::find($product_id);
        if($product){
            $this->product = $product;
        }
    }


    public function updateProductGalery()
    {
        $this->validate(['product_image' => 'image|max:1500|mimes:png,jpg,jpeg']);
        $this->photoExtension = $this->product_image->extension();
        $this->setImageName($this->photoExtension);
        $this->product_image->storeAs('articlesImages', $this->getImageName());
        $intoDB = Image::create(['name' => $this->getImageName(), 'product_id' => $this->product->id]);
        if ($intoDB) {
            $this->dispatchBrowserEvent('hide-form');
            $this->dispatchBrowserEvent('FireAlert', ['title' => 'Mise à jour réussie', 'message' => "La mise à jour de la galerie s'est bien déroulée", 'type' => 'success']);
            $this->emit('productUpdated', $this->product->id);
        }
        else{
            $local = Storage::delete($this->getImageName());
            $this->dispatchBrowserEvent('FireAlert', ['title' => 'Ereur serveur', 'message' => "La mise à jour de la galerie a échoué, veuillez réessayer!", 'type' => 'error']);
            $this->product_image->storeAs('articlesImages', $this->getImageName());
        }

    }


    public function setImageName($extension)
    {
        $name = getdate()['year'].''.getdate()['mon'].''.getdate()['hours'].''.getdate()['minutes'].''.getdate()['seconds']. '' .  Str::random(15) . '.' . $extension;
        $this->product_image_name = $name;
        return $this;
    }

    public function getImageName()
    {
        return $this->product_image_name;
    }

    public function productUpdated($product_id)
    {
        $product = Product::find($product_id);
        if($product){
            $this->emit('productUpdated', $product_id);
        }
    }
}
