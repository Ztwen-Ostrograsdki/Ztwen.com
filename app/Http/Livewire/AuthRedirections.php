<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Rules\StrongPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Events\NewUserConnectedEvent;
use App\Events\NewUserRegistredEvent;
use Illuminate\Support\Facades\Route;
use App\Providers\RouteServiceProvider;

class AuthRedirections extends Component
{
    public $showPassword = false;
    public $showNewPassword = false;
    public $email_auth;
    public $email_for_reset;
    public $password_auth;
    public $email;
    public $name;
    public $password;
    public $new_password;
    public $password_confirmation;
    public $new_password_confirmation;
    public $target;
    public $unverifiedUser = false;
    public $user;
    public $userNoConfirm = false;
    public $reset_password_final_step = false;

    protected $rules = [
        'name' => 'required|string|between:2,255',
        'email' => 'required|email',
        'email_auth' => 'required|email',
        'password' => 'required|string|min:4',
        'password_confirmation' => 'required|string|min:4',
        'new_password' => 'required|string|min:4',
        'new_password_confirmation' => 'required|string|min:5',
        'password' => 'required|string',

    ];

    

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function toogleShowPassword()
    {
        $this->showPassword = !$this->showPassword;
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
        elseif($target == 'password-forgot'){
            $this->target = 'reset_password';
        }
    }

    public function render()
    {
        return view('livewire.auth-redirections');
    }

    public function login()
    {
        $this->reset('userNoConfirm');
        $this->validate([
            'email_auth' => 'required|email',
            'password_auth' => 'required|string|min:4'
        ]);
        $credentials = ['email' => $this->email_auth, 'password' => $this->password_auth];
        $u = User::where('email', $this->email_auth)->first();
        if($u && !$u->hasVerifiedEmail()){
            $this->user = $u;
            $this->email = $u->email;
            $this->emit('newEmailToShouldBeConfirmed', $this->email);
            session()->put('email-to-confirm', $this->email);
            $this->addError('email_auth', "Ce compte n'a pas été confirmé!");
            $this->userNoConfirm = true;
        }
        else{
            if(Auth::attempt($credentials)){
                $this->user = User::find(auth()->user()->id);
                if($this->user->id == 1 || $this->user->role == 'admin' || $this->user->role == 'master'){
                    $this->user->__generateAdminKey();
                }
                $this->dispatchBrowserEvent('Login');
                $event = new NewUserConnectedEvent($this->user);
                broadcast($event);
                $this->user->__backToUserProfilRoute();
            }
            else{
                session()->flash('message', 'Aucune correspondance trouvée');
                session()->flash('type', 'danger');
                $this->addError('email_auth', "Vos renseignements ne sont pas correctes!");
                $this->addError('password_auth', "Vos renseignements ne sont pas correctes!");
            }
        }

       
    }


    public function register()
    {
        $this->auth = Auth::user();
        if($this->auth){
            $this->password = '00000';
            $this->password_confirmation = '00000';
        }
        $v = $this->validate([
            'name' => 'required|string|unique:users|between:5, 50',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|confirmed|min:4',
            'password_confirmation' => 'required|string|min:4'
        ]);
        if ($v) {
            $v = $this->validate(['password' => new StrongPassword(false, false, false, 4)]);
            if($v){
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
                    Auth::login($this->user);
                }
                else{
                    $this->resetErrorBag();
                    $this->dispatchBrowserEvent('hide-form');
                    // $this->user->sendEmailVerificationNotification();
                    $event = new NewUserRegistredEvent($this->user);
                    broadcast($event);
                    session()->put('user_email_to_verify', $this->user->id);
                    return redirect()->route('email-verification-notify', ['id' => $this->user->id]);
                }
                $this->resetErrorBag();
                $this->dispatchBrowserEvent('RegistredNewUser', ['username' => $this->name]);
                $this->emit("refreshUsersList");
                if($this->user->role == 'admin'){
                    return redirect(RouteServiceProvider::ADMIN);
                }
                else{
                    return redirect()->back();
                }
            }
        }

    }

    public function sendCode()
    {
        $this->validate(['email_for_reset' => 'required|email']);
        $user = User::where('email', $this->email_for_reset)->first();
        if($user){
            $this->user = $user;
            if($user->hasVerifiedEmail()){
                $user->forceFill([
                    'reset_password_token' => Str::random(6),
                ])->save();
                $this->user->sendEmailForForgotPasswordNotification();
                return redirect($user->__urlForPasswordReset());
            }
            else{
                $this->dispatchBrowserEvent('FireAlertDoNotClose', ['type' => 'warning', 'message' => "Cette adresse n'a pas encore été confirmé",  'title' => 'Compte non activé']);
                $this->emit('newEmailToShouldBeConfirmed', $this->email_for_reset);
                session()->put('email-to-confirm', $this->email_for_reset);
                $this->addError('email_for_reset', "Ce compte n'a pas été confirmé!");
                $this->userNoConfirm = true;
            }
        }
        else{
            $this->addError('email_for_reset', "L'adresse mail est introuvable");
            $this->dispatchBrowserEvent('FireAlertDoNotClose', ['type' => 'error', 'message' => "L'adresse mail renseillée est introuvable",  'title' => 'Erreur']);
        }
    }


    public function forcedEmailVerification()
    {
        return redirect($this->user->__urlForEmailConfirmation(true));
    }


}
