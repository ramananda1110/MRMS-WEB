<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;

use App\Models\User;
use App\Http\Requests\ResetPasswordRequest;
use Ichtrojan\Otp\Otp;
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

    public function _costruct()
    {
        $this->otp = new Otp;
    }

    // public function passwordReset(ResetPasswordRequest $request)
    // {
    //     $otp2 = $this->otp->validate($request->email, $request->otp);

    //     if(!$otp2->status) {
    //         return response()->json(['error' => $otp2], 401);
    //     }
    //     $user = User::where('email', $request->email)->first();
    //     $user->update(['password' => Hash::make($request->password)]);
    //     $user->tokens()->delete();
    //     $sucess['success'] = true;
    //     return response()->json($sucess, 200);
    // }

    public function passwordReset(ResetPasswordRequest $request)
        {
            $otp2 = $this->otp;

            if (!$otp2) {
                return response()->json(['error' => 'OTP object not found'], 500);
            }

            $validationResult = $otp2->validate($request->email, $request->otp);

            if (!$validationResult->status) {
                return response()->json(['error' => $validationResult], 401);
            }

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            $user->update(['password' => Hash::make($request->password)]);
            $user->tokens()->delete();

            $success['success'] = true;
            return response()->json($success, 200);
        }
}
