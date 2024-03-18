<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CreateNewUserNotification extends Notification
{
    use Queueable;
    public $message;
    public $subject;
    public $fromEmail;
    public $mailer;
    public $userId;
    public $password;
   
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($userId, $password)
    {
        $this->message = 'Below are your login credentials for accessing the MRMS App:';
        $this->subject = 'Welcome to MRMS';
        $this->fromEmail = 'admin@ddcl.bd';
        $this->mailer = 'smtp';
        $this->userId = $userId;
        $this->password = $password;

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
        ->mailer('smtp')
        ->subject($this->subject)
        ->greeting('Hello and welcome to MRMS! ' . $notifiable->first_name)
        ->line($this->message)
        ->line('User ID: ' . $this->userId) // Corrected access to $userId and $password
        ->line('Password: ' . $this->password)
        ->line("To download the MRMS App from Google Play, please click [here]('https://play.google.com/store/apps/details?id=com.adora.mrm&hl=en&gl=US').");

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
