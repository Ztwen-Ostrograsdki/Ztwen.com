<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserChangeEmailNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return (new MailMessage)
            ->subject("Confirmation de mail Ztwen-Oströgrasdki")
            ->line("Monsieur/Madame {$this->user->name}, vous avez lancé une de modification de votre adresse mail")
            ->line("Nous procédons donc à une vérification de votre nouvelle adresse mail renseillée")
            ->line("Si vous reconnaissez la requête d'inscription veuillez cliquer sur le button afin de confirmer votre adresse mail")
            ->line("Si vous ne reconnaissez pas cette requête veuillez juste ignorer ce courriel")
            ->line("")
            ->action('Confirmer adresse mail', $this->getUrl())
            ->line("La clé est: {$this->user->getEmailResetToken()}")
            ->line("")
            ->line("Nous vous remercions de votre fidélité");
        // return $this->view('view.name');
    }

    public function getUrl()
    {
        return $this->verificationUrl();
    }

    protected function verificationUrl()
    {
        return URL::temporarySignedRoute(
            'confirmed-email-verification',
            Carbon::now()->addMinutes(120),
            [
                'id' => $this->user->getKey(),
                'token' => urlencode($this->user->email_verified_token),
                'key' => urlencode($this->user->token),
                'hash' => sha1($this->user->getEmailForVerification()),
            ]
        );
    }
}
