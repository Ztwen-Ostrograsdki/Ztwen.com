<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\UserOnlineSession;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;

class RegisteringNewUser extends Component
{
    public $auth;
    public $user;
    public $name = '';
    public $email = '';
    public $password_confirmation = '';
    public $password = '';
    protected $listeners = ['newUserAdded', 'refreshUsersList', 'newUserConnected'];
    protected $rules = [
        'name' => 'required|string|unique:users|between:5,255',
        'email' => 'required|email|unique:users|between:5,255',
        'password' => 'required|string|confirmed',
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
            ]);
            if($this->user->id == 1){
                $this->user->update(['role' => 'admin']);
            }

            event(new Registered($this->user));
            if(!$this->auth){
                $this->dispatchBrowserEvent('RegistredSelf');
                Auth::login($this->user);
                $connected = Auth::user();
                if($connected){
                    UserOnlineSession::create(['user_id' => $connected->id]);
                    $this->emit("newUserConnected");
                }
            }
            $this->resetErrorBag();
            $this->emit("newUserAdded", $this->name);
            $this->dispatchBrowserEvent('RegistredNewUser', ['username' => $this->name]);
            $this->emit("refreshUsersList");
            $this->dispatchBrowserEvent('hide-form');
            if($this->user->role == 'admin'){
                return redirect(RouteServiceProvider::ADMIN);
            }
            else{
                return redirect()->back();
            }
        }
        else{
            
        }

    }


    public function newUserAdded($user)
    {

    }

    public function refreshUsersList()
    {

    }

    public function newUserConnected()
    {
        
    }
}
