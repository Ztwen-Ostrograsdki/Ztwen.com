<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetEmail extends Notification
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
            ->subject("Confirmation de mail Ztwen-Oströgrasdki")
            ->line("Monsieur/Madame {$notifiable->name}, vous avez lancé une de modification de votre adresse mail")
            ->line("Nous procédons donc à une vérification de votre nouvelle adresse mail renseillée")
            ->line("Si vous reconnaissez la requête d'inscription veuillez cliquer sur le button afin de confirmer votre adresse mail")
            ->line("Si vous ne reconnaissez pas cette requête veuillez juste ignorer ce courriel")
            ->line("")
            ->line("La clé est: {$notifiable->getEmailResetToken()}")
            ->line("")
            ->line("Nous vous remercions de votre fidélité");
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
