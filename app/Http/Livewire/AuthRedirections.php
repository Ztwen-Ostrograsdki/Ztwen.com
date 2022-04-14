<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class AuthRedirections extends Component
{
    public $email_auth;
    public $password_auth;
    public $target;
    protected $rules = [
        'email_auth' => 'required|email|between:5,255',
        'password_auth' => 'required|string',
    ];

    public function mount()
    {
        if(Route::currentRouteName() == 'login'){
            $this->target = 'login';
        }
    }

    public function render()
    {
        return view('livewire.auth-redirections');
    }

    public function login()
    {
       $this->validate();
       $credentials = ['email' => $this->email_auth, 'password' => $this->password_auth];
       if(Auth::attempt($credentials)){
            $this->dispatchBrowserEvent('Login');
            $this->emit("newUserConnected");
            $this->emit("connected", Auth::user()->id);
            Session::put('user-'.Auth::user()->id, Auth::user()->id);
            return redirect('/');
            if(Auth::user()->id == 1){
                
            }
       }
       else{
            session()->flash('message', 'Aucune correspondance trouvée');
            session()->flash('type', 'danger');
            $this->addError('email_auth', "Vos renseignements ne sont pas correctes!");
            $this->addError('password_auth', "Vos renseignements ne sont pas correctes!");
       }
       


    }

}
