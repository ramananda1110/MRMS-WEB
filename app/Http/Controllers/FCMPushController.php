<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FCMPushController extends Controller
{
    

    public function saveToken(Request $request)
    {
        auth()->user()->update(['device_token'=>$request->token]);
        return response()->json(['token saved successfully.']);
    }

  
    public function sendNotification(Request $request)
    {
        // $firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->all();

        //  $firebaseToken = ["eUoA7DUvQwCmmF3EkOdEqp:APA91bE8Px29P0Ci2avaNQbK08mDiyXZxyRzLX9Juu9ISqqik_kMUAvlxhv0OGXD29We_5KlREE7zkpsID3HqvPJEmTBixp8kCtZcW1HRXAVdOxC3l3jIDGYzKubRPy1G4xzgiIKdTa-"];

        $firebaseToken = $request->registration_ids;

        $SERVER_API_KEY = 'AAAA0h17rvo:APA91bH2AJvxddfaxr4Hme_q5WmeDroWdM7CJnQBd_wnjRtEo2-yRogwXeIOA_JdTktjMBWwdU8u6LQzNvLGsaDOPVi3xOmX54mV6agLMs_yfHFOL-NJYUha_uzoWOy64SF3hrt8zrtI';
  
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
      
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
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
