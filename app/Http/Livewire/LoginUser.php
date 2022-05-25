<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\UserOnlineSession;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class LoginUser extends Component
{

    public $unverifiedUser = false;
    public $user;
    public $userNoConfirm = false;

    public function render()
    {
        return view('livewire.login-user');
    }


    public $email;
    public $password;
    protected $rules = [
        'email' => 'required|email|between:5,255',
        'password' => 'required|string',
    ];


    public function login()
    {
        $this->reset('userNoConfirm');
        $this->validate();
        $credentials = ['email' => $this->email, 'password' => $this->password];
        $u = User::where('email', $this->email)->first();
        if($u && !$u->hasVerifiedEmail()){
            $this->addError('email', "Ce compte n'a pas été confirmé!");
            $this->userNoConfirm = true;
        }
        else{
            if(Auth::attempt($credentials)){
                $this->dispatchBrowserEvent('Login');
                $this->dispatchBrowserEvent('hide-form');
                if(auth()->user()->role == 'master'){
                    Redirect::route('admin');
                }
                elseif(auth()->user()->role == 'user'){
                    Redirect::route('user-profil', ['id' => auth()->user()->id]);
                }
            }
            else{
                session()->flash('message', 'Aucune correspondance trouvée');
                session()->flash('type', 'danger');
                $this->addError('email', "Vos renseignements ne sont pas correctes!");
                $this->addError('password', "Vos renseignements ne sont pas correctes!");
            }
        }
    }
}
