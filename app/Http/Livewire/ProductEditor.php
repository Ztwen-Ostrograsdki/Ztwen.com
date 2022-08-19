<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Helpers\ZtwenManagers\ZtwenImageManager;

class ProductEditor extends Component
{
    use WithFileUploads;
    public $product;
    public $product_image = null;
    protected $listeners = ['editProductGaleryEvent'];
    protected $rules = [
        'product_image' => 'image|max:3000|mimes:png,jpg,jpeg'
    ];


    public function render()
    {
        return view('livewire.product-editor');
    }

    public function updateProductGalery()
    {
        $this->validate();
        $make = (new ZtwenImageManager($this->product, $this->product_image))->storer($this->product->imagesFolder);
        if ($make) {
            $this->dispatchBrowserEvent('hide-form');
            $this->dispatchBrowserEvent('Toast', ['title' => 'Mise à jour réussie', 'message' => "La galerie de l'article a été mis à jour avec succès", 'type' => 'success']);
        }
        else{
            $this->dispatchBrowserEvent('Toast', ['title' => 'Ereur serveur', 'message' => "La mise à jour de la galerie a échoué, veuillez réessayer!", 'type' => 'error']);
        }
        
    }


    public function editProductGaleryEvent($product_id)
    {
        $product = Product::find($product_id);
        if($product){
            $this->$product = $product;
            $this->dispatchBrowserEvent('modal-updateProductGalery');
        }
        else{
            return abort(403);
        }
    }

    
}
