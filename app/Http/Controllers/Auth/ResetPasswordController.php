<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

use App\Models\User;
use App\Http\Requests\ResetPasswordRequest;
use Otp;
use Hash;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    // use ResetsPasswords;

    // /**
    //  * Where to redirect users after resetting their password.
    //  *
    //  * @var string
    //  */
    // protected $redirectTo = RouteServiceProvider::HOME;

    private $otp;

    public function __construct(Otp $otp)
    {
        $this->otp = $otp;
    }

    public function verifyOTP(ResetPasswordRequest $request)
    {
        $otp2 = $this->otp->validate($request->email, $request->otp);

        if(!$otp2->status) {
            //return response()->json(['error' => $otp2], 401);
            return response()->json([
                'status_code' => 422,
                'message' => $otp2->message
                 ], 200);
        }

        return response()->json([
            'status_code' => 200,
            'message' => 'OTP has been successfully verified.'
             ], 200);

        // $user = User::where('email', $request->email)->first();

        // $user->update(['password' => Hash::make($request->password)]);
        // $user->tokens()->delete();

        // return response()->json([
        //     'status_code' => 200,
        //     'message' => 'Password has been successfully changed.'
        //      ], 200);
    }

    public function passwordReset(Request $request)
    {
        $email = $request->query('email');
        $password = $request->query('password');

       // dd($email . ' and password '. $password);

        $user = User::where('email', $email)->first();

        $user->update(['password' => Hash::make($password)]);
        $user->tokens()->delete();


        if ($user) {
            return response()->json([
                'status_code' => 200,
                'message' => 'Password has been successfully changed.'
                 ], 200);;
        }

        return response()->json([
            'status_code' => 422,
            'message' => "Password change failed. Email doesn't match."
             ], 200);

       
    }

}
