<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class IsAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {

        
        if (Auth::user() &&  Auth::user()->is_admin == 1) {
             return $next($request);
        }

       return response('Unauthorized.', 401);
    }
}
