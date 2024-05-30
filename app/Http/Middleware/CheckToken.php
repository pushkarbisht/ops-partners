<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class 
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the user has a valid JWT token
        if (!Auth::guard('api')->check()) {
            // Redirect to the login page if no token found
            return redirect('/login');
        }

        return $next($request);
    }
}
