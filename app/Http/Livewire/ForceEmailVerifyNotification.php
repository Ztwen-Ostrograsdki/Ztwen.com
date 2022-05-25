<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ForceEmailVerifyNotification extends Component
{
    protected $listeners = ['sendNewEmailVerificationNotification'];
    public $error = null;
    public $resentToken = false;
    public $token;
    public $key;
    public $email;
    public $email_for_resent;
    public $confirmed = false;
    public $user;
    protected $rules = [
        'token' => 'required|string|min:5|max:16',
        'email' => 'required|email',
    ];

    public function render()
    {
        return view('livewire.force-email-verify-notification');
    }


    public function sendNewForceEmailVerificationNotification($request)
    {
        $this->user = $request;
        $this->mount();
    }

    public function verify()
    {
        $this->validate();
        $user = User::where('email', $this->email)->first();
        if($user){
            if(!$user->hasVerifiedEmail()){
                $this->user = $user;
                if($user->token == $this->token){
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
    }

    public function resentVerificationEmailToken()
    {
        $this->validate(['email_for_resent' => 'required|email']);
        $data = User::withTrashed('deleted_at')->where('email', $this->email_for_resent)->first();
        if($data){
            if(!$data->hasVerifiedEmail()){
                if(!$data->deleted_at){
                    $data->resendEmailVerificationNotification();
                    $this->dispatchBrowserEvent('FireAlertDoNotClose', ['type' => 'success', 'message' => "Votre requête a été avec succès!"]);
                }
                else{
                    $this->addError('email_for_resent', "Adresse mail bloquée");
                    $this->dispatchBrowserEvent('FireAlertDoNotClose', ['type' => 'error', 'message' => "Cette adresse mail a été bloqué. Veuillez contacter un administrateur"]);
                }
            }
            else{
                $this->addError('email_for_resent', "Adresse mail non compatible");
                $this->dispatchBrowserEvent('FireAlertDoNotClose', ['type' => 'error', 'message' => "Vous ne pouvez pas effectuer cette action avec cette adresse mail"]);
            }
        }
        else{
            $this->addError('email_for_resent', "Adresse mail introuvable");
            $this->dispatchBrowserEvent('FireAlertDoNotClose', ['type' => 'error', 'message' => "Vous ne pouvez pas effectuer cette action, l'adresse mail est introuvable..."]);
        }
    }

    public function prepareResentVerificationEmailToken()
    {
        $this->resentToken = true;
    }
}
