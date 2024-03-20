<?php

namespace App\Http\Middleware;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

use Closure;
use Illuminate\Http\Request;

class AuthenticateApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Retrieve the API token from the query parameters
        $apiToken = $request->query('api_token');

        // Attempt to find the user by the API token
        if ($apiToken == null) {
            return response()->json([
                'status_code' => Response::HTTP_UNAUTHORIZED,
                'message' => 'Required API Token!'
            ], Response::HTTP_OK);
        }

        $user = User::where('api_token', $apiToken)->first();

        if (!$user) {
            // If authentication fails, return an error response
            return response()->json([
                'status_code' => Response::HTTP_UNAUTHORIZED,
                'data' => null,
                'message' => 'Unauthorized User!'
            ], Response::HTTP_OK);
        }

        // Authentication succeeded, proceed to the next middleware or the controller
        return $next($request);
    }
}
