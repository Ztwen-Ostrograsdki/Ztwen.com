<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class EmailVerifyNotification extends Component
{
    public $error = null;
    public $token;
    public $key;
    public $email;
    public $confirmed = false;
    public $user;
    protected $rules = ['token' => 'required|string|min:5|max:16'];

    public function mount($id)
    {
        $user = User::find($id);
        if($user){
            if(session()->has('user_email_to_verify')){
                $u = (int)session('user_email_to_verify');
                if($u !== $user->id){
                    return abort(404);
                }
                else{
                    $this->user = $user;
                    if($this->user->token){
                        $this->key = $this->user->token;
                    }
                    else{
                        return abort(403, "La requéte est inconnue");
                    }
                }
            }
            else{
                $this->error = "La session a déjà expiré, Veuillez relancer le proccessus de confirmation ou vérifier votre boite mail!";
            }
        }
        else{
            return abort('404');
        }
    }

    public function render()
    {
        return view('livewire.email-verify-notification');
    }


    public function verify()
    {
        $this->validate();
        if($this->user){
            if(!$this->user->hasVerifiedEmail()){
                if($this->token == $this->key){
                    $this->user->markEmailAsVerified();
                    $this->confirmed = true;
                }
                else{
                    $this->addError('token', "La clé ne correspond pas!");
                    $this->addError('email', "La clé ne correspond pas!");
                }
            }
            else{
                $this->addError('email', "Cette adresse mail est déjà confirmée");
            }
        }
        else{
            $this->addError('email', "Cette adresse mail est inconnue");
        }
    }

    public function forceLogin()
    {
        Auth::login($this->user);
        return redirect()->route('user-profil', ['id' =>$this->user->id]);
    }

    
    public function getToken()
    {
        return $this->user->token;
    }
}
