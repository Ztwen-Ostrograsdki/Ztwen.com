<?php

namespace App\Notifications;

use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ForgotPasswordNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        ->subject("Mot de passe oublié")
        ->line("Monsieur/Madame {$notifiable->name}, nous procedons à la modification votre mot de passe")
        ->line("Nous vous envoyons ce courriel pour vous vérifier si la procedure a été lancé par vous même")
        ->line("Si vous ne reconnaissez pas cette requête veuillez juste ignorer ce courriel")
        ->action("Confirmer", $this->getUrl($notifiable))
        ->line("")
        ->line("")
        ->line("Nous vous remercions de votre fidélité");
    }



    protected function getUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'reset-password',
            Carbon::now()->addMinutes(11),
            [
                'id' => $notifiable->getKey(),
                'token' => urlencode(sha1($notifiable->reset_password_token)),
                'key' => Str::random(8),
                'hash' => sha1($notifiable->getEmailForVerification()),
                's' => $notifiable->reset_password_token,
                'email' => 'yes',
            ]
        );
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
}
