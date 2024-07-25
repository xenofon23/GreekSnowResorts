<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckTokenExpiration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
        {
            if (Auth::check()) {
                $user = Auth::user();
                $token = $request->bearerToken();

                // Retrieve the token from the database
                $tokenModel = $user->tokens()->where('token', hash('sha256', $token))->first();

                if ($tokenModel) {
                    // Check if the token is expired (10 minutes)
                    $lastActivity = $tokenModel->updated_at;
                    if ($lastActivity->diffInMinutes(Carbon::now()) > 10) {
                        // Token expired, logout user
                        Auth::logout();
                        return response()->json(['message' => 'Session expired. Please log in again.'], 401);
                    }
                }
            }

            return $next($request);
        }
}
