<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Twilio\Rest\Client;

class WhatsAppWelcomeNotification extends Notification
{
    use Queueable;
    protected $user;


    /**
     * Create a new notification instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */

     public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

     public function toTwilio($notifiable)
    {
        $sid    = config('services.twilio.sid');
        $token  = config('services.twilio.token');
        $from   = config('services.twilio.whatsapp_from');

        $twilio = new Client($sid, $token);

        $twilio->messages->create(
            // "whatsapp:" . $this->customer->phone, // must be in format +923234667972
            "whatsapp:" . '+923234667972', // must be in format +923234667972
            [
                "from" => $from,
                "body" => "🎉 Welcome, thanks for registering with us!"
            ]
        );
    }
}
