<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Rules\PasswordChecked;

class AdminAuthorization extends Component
{

    public $code;
    public $user;
    public $default_key;

    protected $rules = [
        'code' => 'required|string',
    ];

    public function mount()
    {
        $this->user = User::find(auth()->user()->id);
        if($this->user->hasAdminKey()){
            $this->default_key = $this->user->userAdminKey->key;
        }
        else{
            $this->user->__generateAdminKey();
            $this->default_key = $this->user->userAdminKey->key;
        }
        
    }

    public function updated($code)
    {
        $this->validateOnly($code);
    }

    public function render()
    {
        return view('livewire.admin-authorization');
    }


    public function authentify()
    {
        $this->user->__hydrateAdminSession();
        $this->validate();
        $this->validate(['code' => new PasswordChecked($this->default_key)]);
        $this->dispatchBrowserEvent('FireAlertDoNotClose', ['type' => 'success', 'message' => "Authentification réussie"]);
        $this->user->__regenerateAdminSession();
        $this->user->__regenerateAdminKey();
        return redirect()->route('admin');
        
    }



}
