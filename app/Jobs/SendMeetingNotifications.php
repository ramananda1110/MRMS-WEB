<?php

namespace App\Jobs;

use App\Notifications\MeetingInvitation;
use App\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


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
        Log::info('Sending meeting notifications job executed.');

        // Send push notifications
        $devicesToken = User::where('role_id', 1)->pluck('device_token')->toArray();
        app('App\Http\Controllers\NotificationController')->attemtNotification($devicesToken, "Created a Meeting", "Requested to you a meeting schedule.");

        // Send email notifications
        $userEmails = User::where('role_id', 1)->pluck('email')->toArray();
        foreach ($userEmails as $email) {
            $user = User::where('email', $email)->first();
            if ($user) {
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
}
