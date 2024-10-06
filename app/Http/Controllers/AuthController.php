<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use Illuminate\Http\Response;


class AuthController extends Controller
{
    
    public function login(Request $request)
    {
        $credentials = $request->only('employee_id', 'password');

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if (!$user->is_active) { // Check if user is not active
                // If authentication fails, return an error response
                return response()->json([
                    'status_code' => 422,
                    'user' => null,
                    'message' => "Oops! You are not an active user."
                ], Response::HTTP_OK);
            }

            // Generate a token for the authenticated user
            $token = $user->createToken('auth_token')->plainTextToken;
            //dump($token);

            //update the api_token field
            $user->api_token = $token;
            $user->save();

            // Make department_id and role_id hidden in the JSON response
            $user->makeHidden(['department_id', 'role_id']);

            // Return the user data and the token in the response
            return response()->json([
                'status_code' => Response::HTTP_OK,
                'user' => array_merge($user->toArray(), [
                    'is_admin' => $user->isAdmin(),
                    'api_token' => $token,
                    'department_name' => optional($user->department)->name,
                    'role' => optional($user->role)->name,
                ]),
                'message' => 'Success'
            ]);
        }

        // If authentication fails, return an error response
        return response()->json([
            'status_code' => Response::HTTP_UNAUTHORIZED,
            'user' => null,
            'message' => "Oops! It seems your credentials don't match. Please verify and retry."
        ], Response::HTTP_OK);
    }



    public function logout(Request $request)
    {

        $apiToken = $request->query('api_token');

        // Retrieve the user based on the employee ID
        $user = User::where('api_token', $apiToken)->first();


         // reset device token
        $user->update(['api_token' => null]);
        $user->update(['device_token' => null]);

       
        // If authentication fails, return an error response
        return response()->json([
            'status_code' => Response::HTTP_OK,
            'message' => "You have successfully logout"
        ], Response::HTTP_OK);
    }
}
