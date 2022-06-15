<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

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
        session()->flush();
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
                if($u->reset_password_token){
                    $u->forceFill([
                        'reset_password_token' => null,
                    ])->save();
                }
                $user = User::find(auth()->user()->id);
                if($user->id == 1 || $user->role == 'admin' || $user->role == 'master'){
                    $user->__generateAdminKey();
                }
                $this->dispatchBrowserEvent('Login');
                $this->dispatchBrowserEvent('hide-form');
                $user->__backToUserProfilRoute();
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
