<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailToSubscribedVisitors extends Mailable
{
    use Queueable, SerializesModels;

    public $receiver;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($receiver)
    {
        $this->receiver = $receiver;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       return $this->subject('Abonnement à la new letter')
                   ->view('mails.send-email-to-visitors');
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
