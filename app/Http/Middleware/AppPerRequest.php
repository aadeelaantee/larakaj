<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AppPerRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /*
         |----------------------------------------------------------------------
         | Force application to work in same domain of 
         | APP_URL environment variable.
         |----------------------------------------------------------------------
        */

        url()->formatHostUsing(function() {
            return config('app.url');
        });

        return $next($request);
    }
}
