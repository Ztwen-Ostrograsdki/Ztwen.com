<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\UserOnlineSession;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class LoginUser extends Component
{
    public function render()
    {
        return view('livewire.login-user');
    }


    public $email;
    public $password;
    // protected $listeners = ['newUserAdded'];
    protected $rules = [
        'email' => 'required|email|between:5,255',
        'password' => 'required|string',
    ];


    public function login()
    {
       $this->validate();
       $credentials = ['email' => $this->email, 'password' => $this->password];
       if(Auth::attempt($credentials)){
            
            $this->dispatchBrowserEvent('Login');
            $this->emit("newUserConnected");
            $this->emit("connected", Auth::user()->id);
            $this->dispatchBrowserEvent('hide-form');
            Session::put('user-'.Auth::user()->id, Auth::user()->id);
            return redirect()->back();
            if(Auth::user()->id == 1){
                
            }

       }
       else{
            session()->flash('message', 'Aucune correspondance trouvée');
            session()->flash('type', 'danger');
            $this->addError('email', "Vos renseignements ne sont pas correctes!");
            $this->addError('password', "Vos renseignements ne sont pas correctes!");
       }


    }

    public function newUserAdded($user)
    {

    }


    public function loginNewUser($n)
    {
        $this->name = $n;
    }
}
