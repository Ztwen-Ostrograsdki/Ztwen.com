<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Models\ShoppingBag;
use Illuminate\Support\Facades\Auth;

class ProductProfil extends Component
{

    protected $listeners = [
        'connected', 
        'targetedProduct', 
        'resetTargetedProduct',
        'productUpdated', 
        'updatingFinish',
    ];
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
            }
            else{
                $product = Product::withTrashed('deleted_at')->whereId($id)->firstOrFail();
                if($product){
                    return abort(403, "L'article que vous rechercher a été retiré ou supprimé");
                }
                else{
                    return abort(403, "Votre requête ne peut aboutir désolé");
                }
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
    }

    
    public function render()
    {
        return view('livewire.product-profil');
    }

    public function addNewComment()
    {
        $this->emit('addNewComment', $this->product->id);
    }

    public function liked()
    {
        $user = Auth::user();
        $product = $this->product;
        if($product && $user){
            if($this->user->likedThis('product', $product->id, $this->user->id)){
                $this->mount();
            }
        }
        else{
            return abort(403, "Votre requête ne peut aboutir");
        }
    }

    public function productUpdated($product_id)
    {
        $this->getProduct();
    }

    public function updatingFinish($asset = true)
    {
        $this->updating = false;
        $this->mount();
    }


    public function updateProductGalery($product_id = null)
    {
        if($product_id){
            $id = $product_id;
        }
        else{
            $id = $this->product->id;
        }
        $this->emit('targetedProduct', $id);
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

    public function addToCart($product_id = null)
    {
        if(!$product_id){
            $product = $this->product;
        }
        else{
            $p = Product::find($product_id);
            if($p){
                $product = $p;
            }
            else{
                $this->dispatchBrowserEvent('FireAlertDoNotClose', ['title' => 'Article inconnue', 'message' => "L'article que vous tenter d'ajouter à votre panier est introuvable ou a été déjà retiré!", 'type' => 'warning']);
            }
        }
        if($product){
            $add = $product->__addToUserCart();
            if($add){
                // $this->emit('cartEdited', Auth::user()->id);
                $this->dispatchBrowserEvent('FireAlertDoNotClose', ['title' => 'Ajout réussi', 'message' => "L'article {$product->getName()} a été ajouté à votre panier avec succès!", 'type' => 'success']);
            }
            else{
                $this->dispatchBrowserEvent($product->livewire_product_alert_type, $product->livewire_product_errors);
            }
        }
        // $this->getProduct();

    }


    
    public function deleteFromCart($product_id = null)
    {
        if(!$product_id){
            $product = $this->product;
        }
        else{
            $p = Product::find($product_id);
            if($p){
                $product = $p;
            }
            else{
                $this->dispatchBrowserEvent('FireAlertDoNotClose', ['title' => 'Article inconnue', 'message' => "L'article que vous tenter d'ajouter à votre panier est introuvable ou a été déjà retiré!", 'type' => 'warning']);
            }
        }
        if($product){
            $del = $product->__retrieveFromUserCart();
            if($del){
                $this->emit('cartEdited', Auth::user()->id);
                $this->dispatchBrowserEvent('FireAlertDoNotClose', ['title' => 'Suppression réussie', 'message' => "L'article {$product->getName()} a été retiré de votre panier avec succès!", 'type' => 'success']);
            }
            else{
                $this->dispatchBrowserEvent($product->livewire_product_alert_type, $product->livewire_product_errors);
            }
        }
        $this->getProduct();
    }


    public function connected($user_id)
    {
        $this->getProduct();
    }

}
