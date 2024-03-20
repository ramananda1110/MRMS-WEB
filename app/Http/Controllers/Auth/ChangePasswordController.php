<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User; 
use Illuminate\Http\Response;

class ChangePasswordController extends Controller
{
   
    public function changePassword(Request $request)
    {
       
        // Validate the request data
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6',
            'password_confirmation' => 'required|same:new_password',
        ]);

        // Check if the current password matches the user's password
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status_code' => 422,
                'message' => 'Current password does not match'
                 ], Response::HTTP_OK);
        }

        // Update the user's password
        $user->password = bcrypt($request->new_password);
        $user->save();

        
        return response()->json([
            'status_code' => Response::HTTP_OK,
            'message' => 'Password changed successfully'
             ], Response::HTTP_OK);
    }
    
}
