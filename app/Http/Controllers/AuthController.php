<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use Illuminate\Http\Response;


class AuthController extends Controller
{
    
    public function login2(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();

        return response()->json([
            'user' => $user
        ], Response::HTTP_OK);
    }
    
    public function login(Request $request)
        {
            $credentials = $request->only('email', 'password');

            // Attempt to authenticate the user
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                
                // Generate a token for the authenticated user
                $token = $user->createToken('auth_token')->plainTextToken;

                // Return the user data and the token in the response
                return response()->json([
                    'status_code' => 200,
                    'user' => $user,
                    'user' => array_merge($user->toArray(), [
                        'is_admin' => $user->isAdmin(),
                        'api_token' => $token,
                    ]),
                    'message' => 'Success'
                    
                ], 200);
            }

            // If authentication fails, return an error response
            return response()->json([
                'status_code' => 401,
                'user' => null,
                'message' => 'Unauthorized credentials'
            ], 401);
        }

}
