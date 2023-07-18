<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Check employee login from the incoming request.
 *
 * @author Thu Nandar Aye Min
 * 
 * @created 21/06/2023
*/
class CheckEmployeeLogin
{ 
     /**
     * Handle an incoming request.
     *
     * @author Thu Nandar Aye Min
     * @created 21/06/2023
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (session()->has('employee')) {
            return $next($request);
        }

        return redirect('/login');
    }
}
