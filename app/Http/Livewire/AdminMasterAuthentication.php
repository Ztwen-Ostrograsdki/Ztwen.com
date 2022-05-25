<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class AdminMasterAuthentication extends Component
{
    public $key; 
    public $classeMapping; 
    public $defaultKey = 'abcd';

    protected $listeners = ['adminAuthentication', '__throwAuthenicationModal'];
    protected $rules = [
        'key' => 'required|string|between:1,255',
    ];

    public function render()
    {
        return view('livewire.admin-master-authentication');
    }

    public function adminAuthentication()
    {
        $this->dispatchBrowserEvent('modal-adminAuthenticationModal');
    }

    public function __throwAuthenicationModal()
    {
        $this->dispatchBrowserEvent('modal-adminAuthenticationModal');
    }

    public function authenticate()
    {
        if($this->validate()){
            if($this->key == $this->defaultKey){
                $this->reset('key');
                $this->resetErrorBag();
                $this->dispatchBrowserEvent('hide-form');
                $this->emit('thisAuthenticationIs', true);
            }
            else{
                $this->dispatchBrowserEvent('FireAlert', ['type' => 'error', 'message' => "Vous n'êtes pas authorisé",  'title' => "Echec d'authentification"]);
                return redirect()->back();
            }
        }
    }
    public function refreshThePosts()
    {

    }

    public function refreshCommentsData()
    {
        // $this->comments = Comment::all()->reverse();
    }
    
    public function editAProduct($product_id)
    {
        $product = Product::withTrashed('deleted_at')->whereId($product_id)->firstOrFail();
        if($product){
            $this->emit('editAProduct', $product->id);
            $this->dispatchBrowserEvent('modal-editProduct');
        }
    }
}
