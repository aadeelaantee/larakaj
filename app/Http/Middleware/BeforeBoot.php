<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\App;
use App\Models\LangCode;

class BeforeBoot
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /*
        |-----------------------------------------------------------------------
        |
        |-----------------------------------------------------------------------
        |
        |
        */

        if (!$request->route('langCode')) {

            $request->route()->setParameter(
                'langCode', LangCode::whereDefault(true)->firstOrFail()
            );

        } elseif (gettype($request->route('langCode')) != 'object') {

            $request->route()->setParameter(
                'langCode', LangCode::whereName($request->langCode)->firstOrFail()
            );
        }

        /*
        |-----------------------------------------------------------------------
        | Sharing
        |-----------------------------------------------------------------------
        |
        |
        |
        */ 

        View::share('langCode', $request->route('langCode'));

        URL::defaults([
            'langCode' => $request->route('langCode')->name,
        ]);

        /**
         * 
         */ 
        App::setLocale($request->route('langCode')->name);
        // $request->route()->forgetParameter('langCode');

        return $next($request);
    }
}
