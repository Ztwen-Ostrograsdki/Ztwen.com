<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;


class Admin extends Component
{
    protected $listeners = ['newUserAdded', 'refreshUsersList'];
    public $user;
    public $adminTagName;
    public $adminTagTitle;
    public $users;
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
        $this->users = User::all();
        $this->categories = Category::orderBy('name', 'asc')->get();
        $this->admins = User::where('role', 'admin')->get();
        $this->products = Product::all();
        $this->getUsers();
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


}
