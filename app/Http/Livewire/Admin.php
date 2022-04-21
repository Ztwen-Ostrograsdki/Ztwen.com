<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;


class Admin extends Component
{
    protected $listeners = ['newUserAdded', 'refreshUsersList'];
    public $active = 'active';
    public $user;
    public $adminTagName;
    public $adminTagTitle;
    public $users;
    public $adminTrashedData = false;
    public $admins;
    public $categories;
    public $products;
    public $role;
    public $currentUsersProfil;

    public function mount()
    {
        if(session()->has('adminTagName') && session()->has('adminTagTitle')){
            $this->adminTagName = session('adminTagName');
            $this->adminTagTitle = session('adminTagTitle');
        }
        else{
            $this->adminTagName = "notifications";
            $this->adminTagTitle = "Les notifications";
        }
        if(session()->has('adminTrashedData') && session('adminTrashedData')){
            $this->adminTrashedData = session('adminTrashedData');
            $this->products = Product::onlyTrashed()->orderBy('slug', 'asc')->get();
            $this->categories = Category::onlyTrashed()->orderBy('name', 'asc')->get();
            $this->admins = User::onlyTrashed()->where('role', 'admin')->orderBy('name', 'asc')->get();
            $this->users = User::onlyTrashed()->orderBy('name', 'asc')->get();
        }
        else{
            $this->users = User::orderBy('name', 'asc')->get();
            $this->categories = Category::orderBy('name', 'asc')->get();
            $this->admins = User::where('role', 'admin')->orderBy('name', 'asc')->get();
            $this->products = Product::orderBy('slug', 'asc')->get();
        }

        $this->getUsers();
        $this->refreshAgo();
    }

    public function render()
    {
        return view('livewire.admin');
    }

    public function newUserAdded($user)
    {
        $this->user = $user;
    }

    public function setActiveTag($name, $title)
    {
        $this->adminTagTitle = $title;
        $this->adminTagName = $name;
        session()->put('adminTagName',$name);
        session()->put('adminTagTitle',$title);
        $this->refreshAgo();
    }


    public function refreshAgo()
    {
        foreach ($this->users as $u){
            $u->__setDateAgo();
        }
        foreach ($this->admins as $a){
            $a->__setDateAgo();
        }
        foreach ($this->products as $p){
            $p->__setDateAgo();
        }
    }

    public function getTheTrashedData()
    {
        $this->adminTrashedData = true;
        session()->put('adminTrashedData', $this->adminTrashedData);
        $this->products = Product::onlyTrashed()->orderBy('slug', 'asc')->get();
        $this->categories = Category::onlyTrashed()->orderBy('name', 'asc')->get();
        $this->users = User::onlyTrashed()->orderBy('name', 'asc')->get();
        $this->admins = User::onlyTrashed()->where('role', 'admin')->orderBy('name', 'asc')->get();
        $this->refreshAgo();
    }

    public function getTheActiveData()
    {
        $this->adminTrashedData = false;
        session()->put('adminTrashedData', $this->adminTrashedData);
        $this->users = User::orderBy('name', 'asc')->get();
        $this->categories = Category::orderBy('name', 'asc')->get();
        $this->admins = User::where('role', 'admin')->orderBy('name', 'asc')->get();
        $this->products = Product::orderBy('slug', 'asc')->get();
        $this->refreshAgo();
    }


    public function refreshUsersList()
    {
        return $this->getUsers();
    }

    public function getUsers()
    {
        $data = User::all();
        foreach ($data as $u) {
            if ($u->currentPhoto() !== []) {
                $this->currentUsersProfil[$u->id] = $u->currentPhoto();
                
            }
            else{
                $this->currentUsersProfil[$u->id] = '';
            }
        }
        return $this->users = $data;
    }

    public function updateUserRole($userId, $role)
    {
        $user = User::find($userId);
        if($user){
            $user->update(['role' => $role]);
            $this->emit("refreshUsersList");
            $this->dispatchBrowserEvent('FireAlert', ['type' => 'success', 'message' => "L'utilisateur $user->name a désormais un rôle $role",  'title' => 'Réussie']);
        }else{
            return abort(403, "Vous n'êtes pas authorisé!");
        }
        $this->mount();
    }

    public function deleteAUser($user_id)
    {
        $user = User::find($user_id);
        if($user){
            if($user->deleteThisModel(false)){
                $this->emit('aUserHasBeenDeleted', $user->id);
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'success', 'message' => "L'utilisateur {$user->name} a été envoyé dans la corbeile avec succès",  'title' => 'Réussie']);
                $this->mount();
            }
            else{
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'error ', 'message' => "La suppression de l''utilisateur {$user->name} a échoué",  'title' => 'Echec']);
            }
        }
    }
    public function blockAUser($user_id)
    {
        $user = User::find($user_id);
        if($user){
            if($user->deleteThisModel(false)){
                $this->emit('aUserHasBeenBlocked', $user->id);
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'success', 'message' => "L'utilisateur {$user->name} a été bloqué avec succès",  'title' => 'Réussie']);
                $this->mount();
            }
            else{
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'error ', 'message' => "Le blocage de l''utilisateur {$user->name} a échoué",  'title' => 'Echec']);
            }
        }
    }
    public function restoreAUser($user_id)
    {
        $user = User::withTrashed('deleted_at')->whereId($user_id)->firstOrFail();
        if($user){
            if($user->restoreThisModel()){
                $this->emit('aUserHasBeenRestored', $user->id);
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'success', 'message' => "L'utilisateur {$user->name} a été restauré avec succès",  'title' => 'Réussie']);
                $this->mount();
            }
            else{
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'error ', 'message' => "La restauration de l''utilisateur {$user->name} a échoué",  'title' => 'Echec']);
            }
        }
    }
    public function unblockAUser($user_id)
    {
        $user = User::withTrashed('deleted_at')->whereId($user_id)->firstOrFail();
        if($user){
            if($user->restoreThisModel()){
                $this->emit('aUserHasBeenRestored', $user->id);
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'success', 'message' => "L'utilisateur {$user->name} a été débloqué avec succès",  'title' => 'Réussie']);
                $this->mount();
            }
            else{
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'error ', 'message' => "Le déblocage de l''utilisateur {$user->name} a échoué",  'title' => 'Echec']);
            }
        }
    }

    public function forceDeleteAUser($user_id)
    {
        $user = User::find($user_id);
        if($user){
            if($user->deleteThisModel(true)){
                $this->emit('aUserHasBeenDeleted', $user->id);
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'success', 'message' => "L'utilisateur {$user->name} a été supprimé définivement avec succès",  'title' => 'Réussie']);
                $this->mount();
            }
            else{
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'error ', 'message' => "La suppression définitive de l''utilisateur {$user->name} a échoué",  'title' => 'Echec']);
            }
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

    public function deleteAProduct($product_id)
    {
        $product = Product::find($product_id);
        if($product){
            if($product->deleteThisModel(false)){
                $this->emit('aProductHasBeenDeleted', $product->id);
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'success', 'message' => "L'article {$product->getName()} a été envoyé dans la corbeile avec succès",  'title' => 'Réussie']);
                $this->mount();
            }
            else{
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'error ', 'message' => "La suppression de l'article {$product->getName()} a échoué",  'title' => 'Echec']);
            }
        }
    }

    public function forceDeleteAProduct($product_id)
    {
        $product = Product::withTrashed('deleted_at')->where('id', $product_id)->firstOrFail();
        if($product){
            if($product->deleteThisModel(true)){
                $this->emit('aProductHasBeenDeleted', $product->id);
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'success', 'message' => "L'article {$product->getName()} a été supprimé définivement avec succès",  'title' => 'Réussie']);
                $this->mount();
            }
            else{
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'error ', 'message' => "La suppression de l'article {$product->getName()} a échoué",  'title' => 'Echec']);
            }
        }
    }

    public function hideThisProduct($product_id)
    {
        $product = Product::find($product_id);
        if($product){
            if($product->deleteThisModel(false)){
                $this->emit('aProductHasBeenDeleted', $product->id);
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'success', 'message' => "L'article {$product->getName()} a été masqué avec succès",  'title' => 'Réussie']);
                $this->mount();
            }
            else{
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'error ', 'message' => "Le retrait de l'article {$product->getName()} a échoué",  'title' => 'Echec']);
            }
        }
    }

    
    public function restoreThisProduct($product_id)
    {
        $product = Product::onlyTrashed()->where('id', $product_id)->firstOrFail();
        if($product){
            if($product->restoreThisModel()){
                $this->mount();
                $this->emit('aProductHasBeenRestored', $product->id);
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'success', 'message' => "L'article {$product->getName()} a été restauré avec succès",  'title' => 'Réussie']);
            }
            else{
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'error ', 'message' => "La restauration de l'article {$product->getName()} a échoué",  'title' => 'Echec']);
            }
        }
    }





}
