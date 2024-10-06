<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;

use Illuminate\Http\Request;
use App\Models\Notifications;
use App\Models\NotificationReceiver;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class NotificationController extends Controller
{
    /**
     * Store notifications and attach to participants.
     *
     * @param array $participants
     * @param array $notificationData
     * @return void
     */
    public function createNotification(array $participants, array $notificationData)
    {
        // Store the notification
        $notification = Notifications::create([
            'type' => $notificationData['type'],
            'title' => $notificationData['title'],
            'body' => $notificationData['body'],
            'meeting_id' => $notificationData['meeting_id'],
        ]);

        // Attach notification to participants
        foreach ($participants as $participantId) {
            NotificationReceiver::create([
                'notification_id' => $notification->id,
                'participant_id' => $participantId,
                'is_read' => false
            ]);
        }
    }


    public function createNotificationForHost($participant, array $notificationData)
    {
        // Store the notification
        $notification = Notifications::create([
            'type' => $notificationData['type'],
            'title' => $notificationData['title'],
            'body' => $notificationData['body'],
            'meeting_id' => $notificationData['meeting_id'],
        ]);

        NotificationReceiver::create([
            'notification_id' => $notification->id,
            'participant_id' => $participant,
            'is_read' => false
        ]);
    }


    /**
     * API: Get the count of unread notifications for a participant.
     *
     * @param int $participantId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNotificationCount($participantId)
    {
        $count = NotificationReceiver::where('participant_id', $participantId)
            ->where('is_read', false)
            ->count();

        return response()->json([
            'status_code' => Response::HTTP_OK,
            'new_notification_count' => $count,
            'message' => 'Success'
        ]);
    }

    /**
     * API: Get the notification list for a participant.
     *
     * @param int $participantId
     * @return \Illuminate\Http\JsonResponse
     */
  


     public function getNotifications($participantId)
     {
         // Fetch notifications
         $notifications = NotificationReceiver::where('participant_id', $participantId)
             ->join('notifications', 'notification_receivers.notification_id', '=', 'notifications.id')
             ->select('notifications.id', 'notifications.type', 'notifications.title', 'notifications.body', 'notification_receivers.is_read', 'notifications.created_at')
             ->orderBy('notifications.created_at', 'desc')
             ->limit(10) // Limit to last 10 notifications
             ->get();
     
         // Convert notifications to resources
         $notifications = NotificationResource::collection($notifications);
     
         // Mark all notifications as read
         NotificationReceiver::where('participant_id', $participantId)
             ->update(['is_read' => true]);
     
         return response()->json([
             'status_code' => Response::HTTP_OK,
             'data' => $notifications,
             'message' => 'Success'
         ]);
     }
     

     
    public function checkUser(Request $request)
    {
        // Retrieve the authenticated user's employee ID and role ID
        // $roleId = Auth()->user();
        $token = $request->query('api_token');
        $user = User::where('api_token', $token)->first();

        return response()->json([
            'status_code' => Response::HTTP_OK,
            'data' => $user->role_id,
            'message' => 'Success'
        ]);

    }

}
