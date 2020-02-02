<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\ControllerName;
use App\ControllerFunctionName;
use Session; 
class FunctionSiteController extends Controller
{

	
	public function show(){
		return view('functions.index')->with('controller_function',ControllerFunctionName::where('parent_function_id',0)->get())->with('permissions',Permission::all());		

	}
	////////add or delete Permissions for Site Functions////////////////////////////////////
	public function save($locale,Request $request , $function_id){
		$function = ControllerFunctionName::find($function_id);
		$function->permissions()->sync($request->permission);
		$child_function= ControllerFunctionName::where(['parent_function_id' => $function_id])->get();
		if(!empty($child_function)){
			foreach($child_function as $ch_fun){
				$ch_fun->permissions()->sync($request->permission);
			}				
		}				
		Session::flash('success', 'New permission has been Added');
        return redirect()->back()->withInput();		

	}
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   
}
