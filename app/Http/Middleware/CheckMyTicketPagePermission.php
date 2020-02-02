<?php

namespace App\Http\Middleware;

use Closure;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\ControllerName;
use App\ControllerFunctionName;
class CheckMyTicketPagePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
/////////middleware for my ticket page to check if admin has permission to create ticket for his self can see his tickets/////////////////////	 
    public function handle($request, Closure $next)
    {
		if($request->user()->hasRole('Super Admin') || ($request->user()->admin == 1 && $request->user()->get_permission_for_this_page_link('tickets.create'))){
			return $next($request);
		}
		abort(403,'Not Authorized');

        
    }
}
