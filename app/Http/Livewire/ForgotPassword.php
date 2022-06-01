<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;

class ForgotPassword extends Component
{

    public $user;
    public $email = '';
    protected $rules = [
        'email' => 'required|email|between:5,255',
    ];

    public function render()
    {
        return view('livewire.forgot-password');
    }

    public function submit()
    {
        $this->validate();
        $user = User::where('email', $this->email)->whereNull('email_verified_token')->whereNull('token')->whereNotNull('email_verified_at')->first();
        if($user){
            $user->forceFill([
                'reset_password_token' => Str::random(6),
            ])->save();
            return redirect($user->__urlForPasswordReset());
        }
        else{
            $this->addError('email_for_reset', "L'adresse mail est introuvable");
            $this->dispatchBrowserEvent('FireAlertDoNotClose', ['type' => 'error', 'message' => "L'adresse mail renseillée est introuvable",  'title' => 'Erreur']);
        }
    }


}
