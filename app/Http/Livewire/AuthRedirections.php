<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\UserOnlineSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;

class AuthRedirections extends Component
{
    public $email_auth;
    public $password_auth;
    public $email;
    public $name;
    public $password;
    public $password_confirmation;
    public $target;

    protected function rules()
    {
        if($this->target == 'login'){
            return [
                'email_auth' => 'required|email|between:5,255',
                'password_auth' => 'required|string',
            ];
        }
        elseif($this->target == 'registration'){
            return [
                'name' => 'required|string|unique:users|between:5,255',
                'email' => 'required|email|unique:users|between:5,255',
                'password' => 'required|string|confirmed',
            ];
        }
    }



    public function mount()
    {
        $target = Route::currentRouteName();
        if($target == 'login'){
            $this->target = 'login';
        }
        elseif($target == 'registration'){
            $this->target = 'registration';
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


    public function register()
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

}
