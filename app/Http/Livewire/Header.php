<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Header extends Component
{
    protected $listeners = ['newUserConnected', 'targetedProduct', 'cartEdited', 'userDataEdited'];
    public $user;
    public $username;
    public $carts;
    public $categories;
    public $showCategories = false;


    public function mount()
    {
        $this->getData();
        $this->getUserData();
    }
    public function render()
    {
        return view('livewire.header');
    } 

    public function displayCategories()
    {
        return $this->showCategories = true;
    } 
    public function hideCategories()
    {
        return $this->showCategories = false;
    } 
    public function categorySelected($category_id)
    {
        $this->emit('categorySelected', $category_id);
    } 


    public function booted()
    {
        $this->getUserData();
    }

    public function newUserConnected()
    {
        return $this->user = Auth::user();
    }


    public function getUserData()
    {
        $user = Auth::user();
        if($user){
            $this->user = Auth::user();
            $this->carts = $user->shoppingBags()->count();
        }
    }
    public function getData()
    {
        $this->categories = Category::all();
    }

    public function userDataEdited($user_id)
    {
        if(Auth::user() && $user_id == Auth::user()->id){
            return $this->user = Auth::user();
        }
    }


    public function cartEdited($user_id)
    {
        if(Auth::user() && $user_id == Auth::user()->id){
            $this->getUserData();
        }
    }

    public function targetedProduct($p)
    {
        
    }

    public function createNewProduct()
    {
        $this->emit('createAProduct');
    }

    public function openModalForMyNotifications()
    {
        $this->emit('openModalForMyNotifications');
    }
}
