<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/*
 |------------------------------------------------------------------------------
 | This middleware is for users of this application based on their needs. 
 | Larakaj will not change this file.
 |------------------------------------------------------------------------------
*/

class ForUsersPerRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }
}
