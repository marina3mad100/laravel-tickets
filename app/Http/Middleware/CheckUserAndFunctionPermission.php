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
    public function handle($request, Closure $next)
    {
		$routeArray = app('request')->route()->getAction();
		// dd($routeArray);
		$controllerAction = class_basename($routeArray['controller']);
		list($controller, $action) = explode('@', $controllerAction);
		if($request->user()->hasRole('Super Admin') || (!$request->user()->hasRole('Super Admin') && $request->user()->get_permission_for_this_page_link($routeArray['as']))){
			//$arr_user_permission=$request->user()->get_permission();			
			// if(!empty($arr_user_permission)){
				// $controller_name_id = ControllerName::where('name', $controller)->first();
				// $controller_function = ControllerFunctionName::where(['func_name'=>$action , 'controller_name_id'=>$controller_name_id ->id])->first();	
				// if(isset($controller_function) && !empty($controller_function)){
					// $function_permissions = $controller_function->permissions;
					// $arr_function_permission=array();
					// if(isset($function_permissions) && !empty($function_permissions)){
						// foreach($function_permissions as $fun_permission){
							
							// $arr_function_permission[]=$fun_permission->id;
						// }
					// }
					// if(!empty($arr_function_permission)){
						// foreach($arr_function_permission as $func_permission_id){
							// if(in_array($func_permission_id , $arr_user_permission)){
								return $next($request);
							// }
						// }
					// }
		
				// }
					// abort(403,'Not Authorized');					
				
			// }
			//abort(403,'Not Authorized');
			
			
		
		}
		 abort(403,'Not Authorized');	


        
    }
}
