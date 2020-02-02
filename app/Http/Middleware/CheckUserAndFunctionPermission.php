<?php

namespace App\Http\Middleware;

use Closure;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\ControllerName;
use App\ControllerFunctionName;
class CheckUserAndFunctionPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
	 
////middlewere to check if auth user has permissions for this function ////////////////////////	 
    public function handle($request, Closure $next)
    {
		$routeArray = app('request')->route()->getAction();
		$controllerAction = class_basename($routeArray['controller']);
		list($controller, $action) = explode('@', $controllerAction);
		if($request->user()->hasRole('Super Admin') || (!$request->user()->hasRole('Super Admin') && $request->user()->get_permission_for_this_page_link($routeArray['as']))){
			return $next($request);
		}
		 abort(403,'Not Authorized');	


        
    }
}
