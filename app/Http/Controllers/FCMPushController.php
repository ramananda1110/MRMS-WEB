<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FCMPushController extends Controller
{
    protected $messaging;

    

    public function __construct()
    {
        // Initialize Firebase Messaging using the Service Account credentials
        $this->messaging = (new Factory)
            ->withServiceAccount(storage_path('app/firebase-service-account.json'))
            ->createMessaging(); // Use createMessaging() to get Firebase Messaging instance
    }

    public function saveToken(Request $request)
    {
        // Validate incoming request parameters
        $validator = Validator::make($request->all(), [
            'device_token' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status_code' => 422,
                'message' => $validator->errors()->first()
            ], Response::HTTP_OK);
        }

        $apiToken = $request->input('api_token');
        $deviceToken = $request->input('device_token');

        // Find the user with the given api_token
        $user = User::where('api_token', $apiToken)->first();

        if ($user) {
            $user->update(['device_token' => $deviceToken]);
            return response()->json([
                'status_code' => 200,
                'message' => 'Token saved successfully!'
            ], Response::HTTP_OK);
        }

        return response()->json([
            'status_code' => 422,
            'message' => 'User not found!'
        ], Response::HTTP_OK);
    }


      public function sendNotification(Request $request)
    {
        // $firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->all();

        //  $firebaseToken = ["eUoA7DUvQwCmmF3EkOdEqp:APA91bE8Px29P0Ci2avaNQbK08mDiyXZxyRzLX9Juu9ISqqik_kMUAvlxhv0OGXD29We_5KlREE7zkpsID3HqvPJEmTBixp8kCtZcW1HRXAVdOxC3l3jIDGYzKubRPy1G4xzgiIKdTa-"];

        $firebaseToken = $request->registration_ids;

        $SERVER_API_KEY = 'BNWicb1pdawgiq6Z1RsCECWR09UwRm4hMcCgAjP0_rg1oWXLabC-R3tYA0D4hrEQgDhU7SEaIDECuS4j2qQagZs';
  
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,  
            ]
        ];
       
        $dataString = json_encode($data);
    
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/mrms-79161/messages:send');
        
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
               
        $response = curl_exec($ch);

        curl_close($ch);
  
        //dd($response);
    }




    // HTTP v1 API Version (New Version):
    
    public function sendNotificationV1(Request $request)
    {
        $firebaseTokens = $request->registration_ids; // Array of device tokens

        // Create the notification
        $notification = Notification::create($request->title, $request->body);

        // Prepare the message using CloudMessage::fromArray
        $message = CloudMessage::fromArray([
            'notification' => [
                'title' => $request->title,
                'body'  => $request->body,
            ]
        ]);

        // Send notification to multiple device tokens
        try {
            $sendReport = $this->messaging->sendMulticast($message, $firebaseTokens); 

            if ($sendReport->failures()->count() > 0) {
                return response()->json([
                    'status_code' => 500,
                    'message' => 'Some notifications failed to send.'
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            return response()->json([
                'status_code' => 200,
                'message' => 'Notification sent successfully!',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Failed to send notification: ' . $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


     //  HTTP v1 API Version (New Version):

    public function attemtNotificationV1($deviceTokens, $title, $body)
    {
        // Service account credentials JSON file for HTTP v1 API
        $serviceAccountPath = storage_path('app/firebase-service-account.json');
        
        // Create a new Firebase Messaging instance using the service account
        $firebase = (new \Kreait\Firebase\Factory())
            ->withServiceAccount($serviceAccountPath)
            ->createMessaging();
        
        // Prepare the notification payload
        $notification = \Kreait\Firebase\Messaging\CloudMessage::new()
            ->withNotification([
                'title' => $title,
                'body' => $body,
            ]);

        // Filter null tokens
        $filteredTokens = array_filter($deviceTokens);

        if (!empty($filteredTokens)) {
            // Loop through each device token and send the notification
            foreach ($filteredTokens as $token) {
                try {
                    $message = $notification->withChangedTarget('token', $token);
                    $firebase->send($message);
                } catch (\Exception $e) {
                    // Handle any errors (log them or notify)
                    \Log::error('Notification failed for token ' . $token . ': ' . $e->getMessage());
                }
            }
        }
    }


    // Legacy FCM API Version (Old Version):
    public function attemtNotification($deviceToken, $title, $body)
    {

       
        $SERVER_API_KEY = 'BNWicb1pdawgiq6Z1RsCECWR09UwRm4hMcCgAjP0_rg1oWXLabC-R3tYA0D4hrEQgDhU7SEaIDECuS4j2qQagZs';
  
        $data = [
            "registration_ids" => $deviceToken,
            "notification" => [
                "title" => $title,
                "body" => $body,  
            ]
        ];
       
        $dataString = json_encode($data);
    
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        //curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/mrms-79161/messages:send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
               
        $response = curl_exec($ch);

        curl_close($ch);
  
        //dd($response);
    }

}

