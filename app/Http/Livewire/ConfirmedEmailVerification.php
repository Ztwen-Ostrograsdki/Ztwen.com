<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ConfirmedEmailVerification extends Component
{
    public $user;
    public $key;
    public $email_token;
    public $hash;

    public function mount($id, $token, $key, $hash)
    {
        if($id && $token && $key && $hash){
            $user = User::find($id);
            if($user && !$user->hasVerifiedEmail()){
                if($user->token == urldecode($key) && $user->email_verified_token == urldecode($token) && $user->email == urldecode($hash)){
                    $this->user = $user;
                    $this->email = urldecode($hash);
                    $this->user->markEmailAsVerified();
                }
                else{
                    return abort(403, "Vous requête est corrompue");
                }
            }
            else{
                return abort('404');
            }
        }
        else{
            return abort('404');
        }
    }




    public function render()
    {
        return view('livewire.confirmed-email-verification');
    }


    public function forceLogin()
    {
        Auth::login($this->user);
    }



}
