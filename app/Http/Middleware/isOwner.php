<?php

namespace App\Http\Middleware;

use Closure;

class isOwner
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
        if ($request->user()->admin == 0  && $request->user()->super_admin == 0) {
			return $next($request);            
        }
        abort(403,'Not Authorized');
		
    }
}
