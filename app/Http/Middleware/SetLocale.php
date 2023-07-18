<?php

namespace App\Http\Middleware;

use Closure;

/**
 *  Set the application locale based on the user's session.
 *
 * @author Thu Nandar Aye Min
 * 
 * @created 05/07/2023
 */
class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @author Thu Nandar Aye Min
     * @created 05/07/2023
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->session()->has('locale')) {
            app()->setLocale($request->session()->get('locale'));
        }
        return $next($request);
    }
}
