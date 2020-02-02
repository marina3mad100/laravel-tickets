<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\ControllerName;
use App\ControllerFunctionName;

class User extends Authenticatable
{
    use Notifiable , HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
	
	public function tickets(){
        return $this->hasOne('App\Ticket','user_id','id');
    }
	
	public function admin_assigned(){
        return $this->hasOne('App\Ticket','user_assigned_id','id');
    }
	
	//////// check if auth user has permission to access this route name or function ////////////
	public function get_permission_for_this_page_link($route_name){
		if(!Auth::user()->super_admin == 1){
			/////// if auth user not super admin  , get controller name and action name for route name params /////////////////////////////////////			
			//////// to check if auth user has permission to access this route///////////////////////////////////////					
			$controller_and_function_by_rote = class_basename(Route::getRoutes()->getByName($route_name)->getActionName());
			list($controller, $action) = explode('@', $controller_and_function_by_rote);
			/////// get controller id and  controller action id /////////////////////////////////////			
			$controller_name_id = ControllerName::where('name', $controller)->first();
			if(isset($controller_name_id) && !empty($controller_name_id)){
				$controller_function = ControllerFunctionName::where(['func_name'=>$action , 'controller_name_id'=>$controller_name_id ->id])->first();
			}					
			//////// get all permissions that assigned to this action or function ///////////////////////////			
			if(isset($controller_function) && !empty($controller_function)){
				$function_permissions = $controller_function->permissions;
				$arr_function_permission=array();
				if(isset($function_permissions) && !empty($function_permissions)){
					foreach($function_permissions as $fun_permission){
						
						$arr_function_permission[]=$fun_permission->id;
					}
				}
			}
			/////// get auth user permissions and check if auth user has permission to access this route or action////////////
			$arr_user_permission = $this->get_permission();
			if(!empty($arr_function_permission)){
				foreach($arr_function_permission as $func_permission_id){
					if(in_array($func_permission_id , $arr_user_permission)){
						return true;
					}
				}
			}	
			return false;					
		}
		return true;
	}
		
	
	
	public function get_permission(){
		$user_permissions = $this->getAllPermissions();
		$arr_user_permission=array();
		if(isset($user_permissions) && !empty($user_permissions)){
			foreach($user_permissions as $user_permission){				
				$arr_user_permission[]=$user_permission->id;
			}
		}		
		
		return $arr_user_permission;
		
		
	}
	
	public function is_owner(){
		if(Auth::user()->super_admin == 0 && Auth::user()->admin == 0){
			return true;
		}
		return false;
	}


}
