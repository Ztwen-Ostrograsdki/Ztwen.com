<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Cart extends Component
{
    public $carts_counter;

    public function getUserCart()
    {
        $carts = [];
        $data = auth()->user()->shoppingBags->pluck('product_id')->toArray();
        if(count($data) > 0){
            $carts = Product::whereIn('id', $data)->get();
        }
        return $carts;

    }

    public function refreshCartsCounter()
    {
        $this->carts_counter = count(auth()->user()->shoppingBags->pluck('product_id')->toArray());
    }

    public function render()
    {
        $user = Auth::user();
        if($user){
            $user = $user;
            $carts = $this->getUserCart();
            $products = $carts;
        }
        return view('livewire.cart', compact('user', 'carts', 'products'));
    }

    public function addToCart($product_id = null)
    {
        if(!$product_id){
            $product = null;
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
                $this->emit('myCartWasUpdated', Auth::user()->id);
                $this->dispatchBrowserEvent('FireAlertDoNotClose', ['title' => 'Ajout réussi', 'message' => "L'article {$product->getName()} a été ajouté à votre panier avec succès!", 'type' => 'success']);
            }
            else{
                $this->dispatchBrowserEvent($product->livewire_product_alert_type, $product->livewire_product_errors);
            }
        }

        $this->refreshCartsCounter();

    }
    
    public function deleteFromCart($product_id = null)
    {
        if(!$product_id){
            $product = null;
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
                $this->emit('myCartWasUpdated', Auth::user()->id);
                $this->dispatchBrowserEvent('FireAlertDoNotClose', ['title' => 'Suppression réussie', 'message' => "L'article {$product->getName()} a été retiré de votre panier avec succès!", 'type' => 'success']);
            }
            else{
                $this->dispatchBrowserEvent($product->livewire_product_alert_type, $product->livewire_product_errors);
            }
        }
        $this->refreshCartsCounter();
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
        if($product && auth()->user()){
            $user = User::find(auth()->user()->id);
            if($user->likedThis('product', $product->id, auth()->user()->id)){
                $this->getUserCart();
            }
        }
        else{
            return abort(403, "Votre requête ne peut aboutir");
        }
    }
}
