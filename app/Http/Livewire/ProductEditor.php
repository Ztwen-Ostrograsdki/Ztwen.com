<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Image;
use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
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
        
        if($this->authenticated()){
            $this->validate(['product_image' => 'image|max:1500|mimes:png,jpg,jpeg']);
            $this->photoExtension = $this->product_image->extension();
            $this->setImageName($this->photoExtension);
            $first = null;

            $oldsImages = $this->product->images;
            if($oldsImages->count() > 2){
                $first = $oldsImages->first();
            }
            $this->product_image->storeAs('articlesImages', $this->getImageName());
            $intoDB = Image::create(['name' => $this->getImageName(), 'product_id' => $this->product->id]);
            if ($intoDB) {
                if($first){
                    $local = Storage::delete($first->name);
                    $first->delete();
                }
                $this->dispatchBrowserEvent('hide-form');
                $this->emit('updatingFinish', true);
                $this->dispatchBrowserEvent('FireAlert', ['title' => 'Mise à jour réussie', 'message' => "La mise à jour de la galerie s'est bien déroulée", 'type' => 'success']);
            }
            else{
                $local = Storage::delete($this->getImageName());
                $this->emit('updatingFinish', true);
                $this->dispatchBrowserEvent('FireAlert', ['title' => 'Ereur serveur', 'message' => "La mise à jour de la galerie a échoué, veuillez réessayer!", 'type' => 'error']);
            }
            $this->emit('updatingFinish', true);
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


    public function authenticated()
    {
        if(Auth::user()){
            if(User::find(Auth::user()->id)->__hasAdminAuthorization()){
                return true;
            }
            else{
                return $this->dispatchBrowserEvent('FireAlertDoNotClose', ['title' => 'Authentification requise', 'message' => "Veuillez vous enthentifier avant de lancer des mises à jour", 'type' => 'warning']);
            }
        }
        else{
            return redirect()->route('login');
        }
    }

    
}
