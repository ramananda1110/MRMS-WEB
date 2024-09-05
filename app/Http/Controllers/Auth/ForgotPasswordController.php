<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

use App\Models\User;
use App\Notifications\ResetPasswordVerificationNotification;
use App\Http\Requests\ForgetPasswordRequest;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    //use SendsPasswordResetEmails;


    public function forgotPassword(Request $request){
        // $input = $request->only('email');
        $email = $request->query('email');

        
        $user = User::where('email', $email)->first();
       // $user = User::where('email', $input['email'])->first();

        if (!$user) {
        return response()->json([
           'status_code' => 422,
           'message' => 'Email address not found!'
            ], 200);
        } 

        //dd($user);
         $user->notify(new ResetPasswordVerificationNotification());
        // $success['success'] = true;
        // return response()->json($success, 200);

        return response()->json([
            'status_code' => 200,
            'message' => 'Verification code OTP has been sent to your email.'
             ], 200);
    }
}
