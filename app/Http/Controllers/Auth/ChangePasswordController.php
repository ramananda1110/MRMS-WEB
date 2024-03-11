<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User; 
use Illuminate\Support\Facades\Log;

class ChangePasswordController extends Controller
{
   
    public function changePassword(Request $request)
    {
        // Retrieve the API token from the query parameters
        $apiToken = $request->query('api_token');

        // Log the API token for debugging
        Log::info('API Token from Request:', ['api_token' => $apiToken]);

        // Attempt to find the user by the API token
        $user = User::where('api_token', $apiToken)->first();

        Log::info('User retrieved using API Token:', ['user' => $user]);

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Validate the request data
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6',
            'password_confirmation' => 'required|same:new_password',
        ]);

        // Check if the current password matches the user's password
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['error' => 'Current password does not match'], 401);
        }

        // Update the user's password
        $user->password = bcrypt($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password changed successfully'], 200);
    }
    
}
