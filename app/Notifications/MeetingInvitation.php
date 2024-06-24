<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MeetingInvitation extends Notification
{
    use Queueable;

    public $id;
    protected $meetingTitle;
    protected $startDate;
    protected $startTime;
    protected $endTime;
    protected $duration;
    protected $location;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($id, $meetingTitle, $startDate, $startTime, $endTime, $location)
    {
        $this->id = $id;
        $this->meetingTitle = $meetingTitle;
        $this->startDate = $startDate;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->location = $location;
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
        ->subject('Meeting Invitation: ' . $this->meetingTitle)
        ->greeting('Hello ' . $notifiable->first_name . ',')
        ->line('You have been invited to a meeting titled "' . $this->meetingTitle . '".')
        ->line('**Date:** ' . $this->startDate)
        ->line('**Start Time:** ' . $this->startTime)
        ->line('**End Time:** ' . $this->endTime)
        ->line('**Location:** ' . $this->location)
        ->line('Please review the meeting details and accept the invitation if you are available.')
        ->action('View Meeting Details', url('/meeting-view/' . $this->id))
        ->line('If you have any questions, feel free to contact us.')
        ->line('Thank you!');
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
