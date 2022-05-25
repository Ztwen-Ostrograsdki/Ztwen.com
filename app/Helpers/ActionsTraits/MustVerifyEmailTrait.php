<?php

namespace App\Helpers\ActionsTraits;

use App\Notifications\ResetEmail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Notifications\SentEmailVerificationToUser;


trait MustVerifyEmailTrait
{
    /**
     * Determine if the user has verified their email address.
     *
     * @return bool
     */
    public function hasVerifiedEmail()
    {
        return ! is_null($this->email_verified_at);
    }

    /**
     * Mark the given user's email as verified.
     *
     * @return bool
     */
    public function markEmailAsVerified()
    {
        if($this->id == 1){
            return $this->forceFill([
                'email_verified_at' => $this->freshTimestamp(),
                'email_verified_token' => null,
                'role' => 'master',
                'token' => null,
            ])->save();
        }
        return $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
            'email_verified_token' => null,
            'token' => null,
        ])->save();
       
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new SentEmailVerificationToUser);
    }
    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function __resetEmail($newEmail)
    {
        if($newEmail){
            $this->notify(new ResetEmail($newEmail));
        }
        return false;
    }

    /**
     * Resend the email verification notification.
     *
     * @return void
     */
    public function resendEmailVerificationNotification()
    {
        $this->forceFill([
            'token' => Str::random(6),
            'email_verified_token' => Hash::make(Str::random(16)),
        ])->save();
        $this->notify(new SentEmailVerificationToUser);
        session()->put('user_email_to_verify', $this->id);
        return redirect()->route('email-verification-notify', ['id' => $this->id]);
    }

    /**
     * Get the email address that should be used for verification.
     *
     * @return string
     */
    public function getEmailForVerification()
    {
        return $this->email;
    }

    /**
     * Get the token to verify the email registred
     *
     * @return void
     */
    public function getToken()
    {
        return $this->token;
    }
    /**
     * Get the token to verify the email registred
     *
     * @return void
     */
    public function getEmailResetToken()
    {
        return $this->emailConfirmation->token;
    }


    public function __updatePasswordCodeHasVerified($code)
    {
        return true;
    }

}
