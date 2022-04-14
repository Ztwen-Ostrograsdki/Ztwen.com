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
        $this->activeTagName = (new ProfilManager('demandes', "Les demandes d'ajout"))->name;
        $this->activeTagTitle = (new ProfilManager('demandes', "Les demandes d'ajout"))->title;
        $this->user = User::find($id);
        $this->getDemandes();
        $this->getUserCart();
        $this->getMyFollowers();
        $this->profilImage = $this->user->currentPhoto();
        if(!$this->user){
            abort(404);
        }
        if(Auth()->user()->id !== $this->user->id){
            abort(403);
        }

    }

    public function booted()
    {
        $this->getDemandes();
        $this->getMyFollowers();
    }

    public function getUserCart()
    {
        $this->carts = $this->user->shoppingBags;
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
        $this->booted();
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
    }

    public function getMyProducts()
    {
        $allProducts = Product::all();

        $this->myProducts = $allProducts;
        foreach($this->myProducts as $p){
            $this->myProductsComments[$p->id] = $p->comments;
        }
        
    }

    

}
