<?php

namespace App\Jobs;

use App\Notifications\MeetingInvitation;

use App\Models\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log; 


class SendMeetingNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $meeting;
    protected $meetingDetails;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($meeting, $meetingDetails)
    {
        $this->meeting = $meeting;
        $this->meetingDetails = $meetingDetails;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('SendMeetingNotifications job started.');

        // Batch send push notifications
        $users = User::where('role_id', 1)->get();
        
       
        // Throttle emails to avoid overwhelming the server
        foreach ($users as $user) {
            if ($this->shouldSendEmailToUser($user)) {
                // Send email notifications using Laravel's Notification system
                $user->notify(new MeetingInvitation(
                    $this->meetingDetails['id'],
                    $this->meetingDetails['title'],
                    $this->meetingDetails['start_date'],
                    $this->meetingDetails['start_time'],
                    $this->meetingDetails['end_time'],
                    $this->meetingDetails['location']
                ));
            }
        }

        Log::info('Meeting notifications sent successfully.');
    }


    protected function shouldSendEmailToUser($user)
    {
        // Customize your throttling logic, e.g., skip email if the user received one recently
        // For now, this method returns true, but you can add time-based checks here
        return true;
    }
}
