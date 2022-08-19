<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ProductProfil extends Component
{

    protected $listeners = [
        'newCommentAddEvent', 'aCommentWasApprovedEvent'
    ];
    public $slug;

    public function mount(string $slug)
    {
        $slug = (string)request()->slug;
        if($slug){
            $product = Product::whereSlug($slug)->first();
            if($product){
                $this->slug = $slug;
            }
            else{
                return abort(404);
            }
        }
    }

    public function render()
    {
        if($this->slug){
            $product = Product::whereSlug($this->slug)->first();
            $product->update(['seen' => $product->seen + 1]);
            $comments = $product->comments->where('approved', true)->where('blocked', false)->reverse()->take(6);

        }
        return view('livewire.product-profil', compact('product', 'comments'));
    }

    public function addNewComment()
    {
        $product = Product::whereSlug($this->slug)->first();
        $this->emit('addNewComment', $product->id);
    }

    public function likedThis($product_id = null)
    {
        $user = Auth::user();
        if($user){
            $product = Product::whereSlug($this->slug)->first();
            if($product){
                $user = User::find($user->id);
                if($user->__likedThis($product->id)){
                    $this->dispatchBrowserEvent('ToastDoNotClose', ['title' => 'LIKE', 'message' => "Vous avez liker l'article {$product->getName()} !", 'type' => 'success']);
                }
            }
            else{
                $this->dispatchBrowserEvent('ToastDoNotClose', ['title' => 'Article inconnue', 'message' => "L'article que vous tenter de liker est introuvable ou a été déjà retiré!", 'type' => 'warning']);
            }
        }
        else{
            $this->dispatchBrowserEvent('ToastDoNotClose', ['title' => 'Connexion requise', 'message' => "Veuillez vous connecter avant d'exécuter cette action!", 'type' => 'warning']);
        }
    }


    public function updateProductGalery($product_id = null)
    {
        $product = Product::whereSlug($this->slug)->first();
        $this->emit('editProductGaleryEvent', $product->id);
    }

    public function editAProduct()
    {
        $product = Product::whereSlug($this->slug)->first();
        $this->emit('editAProduct', $product->id);
        $this->dispatchBrowserEvent('modal-editProduct');
    }

    public function bought()
    {

    }

    public function addToCart($product_id = null)
    {
        $product = Product::whereSlug($this->slug)->first();
        if($product){
            $add = $product->__addToUserCart();
            if($add){
                $this->dispatchBrowserEvent('Toast', ['title' => 'Ajout réussi', 'message' => "L'article {$product->getName()} a été ajouté à votre panier avec succès!", 'type' => 'success']);
            }
            else{
                $this->dispatchBrowserEvent($product->livewire_product_alert_by_toast, $product->livewire_product_errors);
            }
        }
    }


    
    public function deleteFromCart($product_id = null)
    {
        $product = Product::whereSlug($this->slug)->first();
        if($product){
            $del = $product->__retrieveFromUserCart();
            if($del){
                $this->dispatchBrowserEvent('Toast', ['title' => 'Suppression réussie', 'message' => "L'article {$product->getName()} a été retiré de votre panier avec succès!", 'type' => 'success']);
            }
            else{
                $this->dispatchBrowserEvent($product->livewire_product_alert_by_toast, $product->livewire_product_errors);
            }
        }
    }


    public function newCommentAddEvent()
    {
        
    }


    public function aCommentWasApprovedEvent()
    {

    }

}
