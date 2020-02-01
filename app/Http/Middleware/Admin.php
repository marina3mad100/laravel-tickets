<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()->admin == 1  || $request->user()->super_admin == 1) {
			return $next($request);            
        }
        abort(403,'Not Authorized');
		
    }
}
