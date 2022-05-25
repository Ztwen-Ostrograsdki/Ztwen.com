<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SentEmailVerificationToUser extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject("Confirmation de compte Ztwen-Oströgrasdki")
                    ->line("Monsieur/Madame {$notifiable->name}, vous avez lancé l'inscription sur la plateforme Ztwen-Oströgrasdki")
                    ->line("Nous procédons donc à une vérification de l'adresse mail renseillée")
                    ->line("Si vous reconnaissez la requête d'inscription veuillez cliquer sur le button afin de confirmer votre compte")
                    ->line("Si vous ne reconnaissez pas cette requête veuillez juste ignorer ce courriel")
                    ->action('Confirmer mon compte', $this->getUrl($notifiable))
                    ->line("")
                    ->line("La clé est: {$notifiable->getToken()}")
                    ->line("")
                    ->line("Nous vous remercions de votre fidélité");
    }

    
    public function getUrl($notifiable)
    {
        return $this->verificationUrl($notifiable);
    }


    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'confirmed-email-verification',
            Carbon::now()->addMinutes(120),
            [
                'id' => $notifiable->getKey(),
                'token' => urlencode($notifiable->email_verified_token),
                'key' => urlencode($notifiable->token),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}
