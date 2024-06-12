<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    protected function credentials(Request $request)
    {
        // Override the credentials method to use 'employee_id' instead of 'email'
     

        return $request->only('employee_id', 'password');
    }

    public function username()
    {
        return 'employee_id';
    }


    protected function authenticated(Request $request, $user)
    {
        // Check if the user is active
        if (!$user->is_active) {
            // Log the user out if they are not active
            Auth::logout();

            // Redirect to login page with an error message
            return redirect()->route('login')->withErrors([
                'password' => 'Your account is not active.',
            ]);
        }

        if($user->api_token == null){
            // Generate a token for the authenticated user
            $token = $user->createToken('auth_token')->plainTextToken;

            // Update the api_token field in the database
            $user->api_token = $token;
            $user->save();

        }

        // Optionally, return a response with the token
        // return response()->json([
        //     'message' => 'Login successful',
        //     'token' => $token,
        // ]);
    }
}
