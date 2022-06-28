<?php

namespace App\Http\Livewire;

use App\Events\NewUserRegistredEvent;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteringNewUser extends Component
{
    public $auth;
    public $user;
    public $name = '';
    public $email = '';
    public $password_confirmation = '';
    public $password = '';
    protected $listeners = [];
    protected $rules = [
        'name' => 'required|string|unique:users|between:5,255',
        'email' => 'required|email|unique:users|between:5,255',
        'password' => 'required|string|confirmed|between:5, 255',
    ];


    public function render()
    {
        return view('livewire.registering-new-user');
    }

    public function submit()
    {
        $this->auth = Auth::user();
        if($this->auth){
            $this->password = '00000';
            $this->password_confirmation = '00000';
        }
        if ($this->validate()) {
            $this->user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'token' => Str::random(6),
                'email_verified_token' => Hash::make(Str::random(16)),
            ]);
            if($this->user->id == 1){
                $this->user->markEmailAsVerified();
            }
            else{
                $masterAdmin = User::find(1);
                if($masterAdmin){
                    $masterAdmin->__followThisUser($this->user->id, true);
                }
            }
            if(!$this->auth && $this->user->id == 1){
                $this->dispatchBrowserEvent('RegistredSelf');
                $this->resetErrorBag();
                $this->dispatchBrowserEvent('hide-form');
                Auth::login($this->user);
                $this->dispatchBrowserEvent('Login');
                $this->user->__backToUserProfilRoute();

            }
            else{
                $this->resetErrorBag();
                $this->dispatchBrowserEvent('hide-form');
                $this->user->sendEmailVerificationNotification();
                $event = new NewUserRegistredEvent($this->user);
                broadcast($event);
                session()->put('user_email_to_verify', $this->user->id);
                return redirect()->route('email-verification-notify', ['id' => $this->user->id]);
            }
            $this->resetErrorBag();
            $this->dispatchBrowserEvent('RegistredNewUser', ['username' => $this->name]);
            $this->emit("refreshUsersList");
            $this->dispatchBrowserEvent('hide-form');
            
        }
        else{
            
        }

    }


}
