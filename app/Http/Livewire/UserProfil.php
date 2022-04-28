<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Product;
use Livewire\Component;
use App\Models\MyRequest;
use App\Models\FollowSystem;
use Livewire\WithFileUploads;
use App\Helpers\ProfilManager;
use App\Models\FollowingSystem;
use Illuminate\Support\Facades\Auth;

class UserProfil extends Component
{
    public $user;
    public $carts;
    public $profilImage;
    public $activeTagName;
    public $activeTagTitle;
    public $demandes;
    public $myFollowers = [];
    public $myProducts;
    public $myProductsComments = [];

    protected $listeners = ['userProfilUpdate'];

    use WithFileUploads;


    public function mount($id)
    {
        if(session()->has('userProfilTagName') && session()->has('userProfilTagTitle')){
            $this->activeTagName = session('userProfilTagName');
            $this->activeTagTitle = session('userProfilTagTitle');
        }
        else{
            $this->activeTagName = (new ProfilManager('demandes', "Les demandes d'ajout"))->name;
            $this->activeTagTitle = (new ProfilManager('demandes', "Les demandes d'ajout"))->title;
        }
        $this->user = User::find($id);
        $this->getDemandes();
        $this->getMyFollowers();
        $this->profilImage = $this->user->currentPhoto();
        if(!$this->user){
            return abort(403, "Vous n'êtes pas authorisé");
        }
        if(Auth()->user()->id !== $this->user->id){
            return abort(403, "Vous n'êtes pas authorisé");
        }
        $this->getUserCart();

    }

    public function getUserCart()
    {
        $this->carts = [];
        $carts = $this->user->shoppingBags->pluck('product_id')->toArray();
        if(count($carts) > 0){
            $this->carts = Product::whereIn('id', $carts)->get();
        }
        $this->reformateDates($this->carts);
    }

    public function reformateDates($data = [])
    {
        if($data == []){
            $data = $this->carts;
        }
        
    }

    public function getMyFollowers()
    {
        $this->myFollowers = $this->user->getMyFollowers();
    }

    public function render()
    {
        return view('livewire.user-profil');
        
    }
    public function userProfilUpdate($id)
    {
        return $this->mount($id);
    }

    public function setActiveTag($name, $title)
    {
        $this->activeTagName = (new ProfilManager($name, $title))->name;
        $this->activeTagTitle = (new ProfilManager($name, $title))->title;
        session()->put('userProfilTagName', $name);
        session()->put('userProfilTagTitle', $title);
        $this->reformateDates();
        $this->mount($this->user->id);
    }
    public function getDemandes()
    {
        $user = Auth::user();
        if($user){
            $this->demandes = $user->myFollowedsRequests();
        }
        else{
            $this->demandes = [];
        }

    }

    public function requestManager($user_id, $action)
    {
        $auth = Auth::user();
        $user = User::find($user_id);
        $req = FollowingSystem::where('follower_id', $user_id)->where('followed_id', $auth->id)->first();
        if($req && $user && $auth){
            
            if($action == "accepted"){
                $req->update(['accepted' => true]);
                MyRequest::create([
                    'user_id' => $user_id,
                    'target_id' => $auth->id,
                    'request_object' => $auth->name . " a accepté votre demande. Veuillez accepter sa demande aussi afin que vous soyez amis!!!"
                ]);
                MyRequest::create([
                    'user_id' => $auth->id,
                    'target_id' => $user_id,
                    'request_object' => $auth->name . ", vous avez accepté la demande de $user->name. Veuillez lui envoyez une demande aussi afin que vous soyez amis!!!"
                ]);
    
            }
            elseif($action == "refused"){
                $req->delete();
                $this->emit('updateRequests');
            }
        }
        $this->mount($this->user->id);
    }

    public function cancelRequestFriend($user_id)
    {
        $auth = Auth::user();
        $user = User::find($user_id);
        $req = FollowingSystem::where('follower_id', $auth->id)->where('followed_id', $user->id)->first();
        if($req && $user && $auth){
            $req->delete();
            $this->emit('updateRequests');
        }
        $this->mount($this->user->id);
    }

    public function followThisUser($user_id)
    {
        $user = User::find($user_id);
        if($user){
            FollowingSystem::create(
                [
                    'follower_id' => Auth::user()->id,
                    'followed_id' => $user->id
                ]);
        }
        $this->mount($this->user->id);
    }


    public function addToCart($product_id)
    {
        $product = Product::find($product_id);
        if($product && $this->user){
            if($this->user->addToCart($product->id)){
                $this->dispatchBrowserEvent('FireAlert', ['title' => 'Réussie', 'message' => "vous avez ajouté l'article {$product->getName()} à votre panier", 'type' => 'success']);
                $this->emit('cartEdited', $this->user->id);
            }
            else{
                return abort(403, "Votre requête ne peut aboutir");
            }
        }
        $this->mount($this->user->id);
    }

    public function deleteFromCart($product_id)
    {
        $product = Product::find($product_id);
        if($product && $this->user){
            if($this->user->deleteFromCart($product->id)){
                $this->emit('cartEdited', $this->user->id);
                $this->dispatchBrowserEvent('FireAlert', ['title' => 'Réussie', 'message' => "L'article {$product->getName()} a été retiré de votre panier", 'type' => 'success']);
            }
            else{
                return abort(403, "Votre requête ne peut aboutir");
            }
        }
        $this->mount($this->user->id);
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
        if($product && $this->user){
            if($this->user->likedThis('product', $product->id, $this->user->id)){
                $this->getUserCart();
            }
        }
        else{
            return abort(403, "Votre requête ne peut aboutir");
        }
    }

    

}
