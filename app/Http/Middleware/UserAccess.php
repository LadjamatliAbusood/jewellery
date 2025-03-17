<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;  // Import Auth facade

class UserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $userType
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, $userType): Response
    {
        // Use Auth::check() to check if the user is authenticated
        // if (Auth::check() && Auth::user()->type == $userType) {
        //     return $next($request);  // Proceed with the request
        // }
        
        $expectedType = is_numeric($userType) ? (int) $userType : $userType;

        if (auth()->check() && auth()->user()->type === $expectedType) {
            return $next($request);
        }
    
        // Return error if the user does not have permission
        return response()->json(['You do not have permission to access this page'], 403);
    }
}
