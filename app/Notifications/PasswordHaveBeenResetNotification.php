<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PasswordHaveBeenResetNotification extends Notification
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
        ->subject("Changement de mot de passe")
        ->line("Monsieur/Madame {$notifiable->name}, vous venez de modifier votre mot de passe")
        ->line("Nous vous envoyons ce courriel pour vous notifier que la mise à jour s'est bien déroulée")
        ->line("Si vous ne reconnaissez pas cette requête veuillez juste ignorer ce courriel")
        ->action('Mon profil', url('/profil/'.$notifiable->id))
        ->error("Ce n'était pas moi", $this->isNotMeUrl($notifiable))
        ->line("")
        ->line("")
        ->line("Nous vous remercions de votre fidélité");
    }
    protected function isNotMeUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'block-temporary-account',
            Carbon::now()->addDays(7),
            [
                'id' => $notifiable->getKey(),
                'token' => urlencode(sha1($notifiable->getEmailForVerification())),
                'hash' => sha1($notifiable->getEmailForVerification()),
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
