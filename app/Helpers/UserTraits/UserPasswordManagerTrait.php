<?php

namespace App\Helpers\UserTraits;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Notifications\ForgotPasswordNotification;
use App\Notifications\PasswordHaveBeenResetNotification;

trait UserPasswordManagerTrait{

    public function __urlForPasswordReset()
    {
        return URL::temporarySignedRoute(
            'reset.password',
            Carbon::now()->addMinutes(11),
            [
                'id' => $this->getKey(),
                'token' => urlencode(sha1($this->reset_password_token)),
                'key' => Str::random(8),
                'hash' => sha1($this->getEmailForVerification()),
                'email' => 'no',
                's' => 'no',
            ]
        );
    }


     /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailForForgotPasswordNotification()
    {
        $this->notify(new ForgotPasswordNotification);
    }
    
    public function sendEmailForPasswordHaveBeenResetNotification($secure = false)
    {
        $this->notify(new PasswordHaveBeenResetNotification);
    }


    public function disconnectUserForSecure()
    {
        Auth::guard('web')->logout();
        Session::flush();
        return redirect()->route('login');
    }
    
    
}