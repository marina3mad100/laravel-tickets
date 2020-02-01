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
	public function save($locale,Request $request , $function_id){
        // $this->validate($request,[
            // 'permission' => 'required'
        // ]);

		$function = ControllerFunctionName::find($function_id);
		$function->permissions()->sync($request->permission);
	

		// $parent_function = ControllerFunctionName::where(['id' => $function->parent_function_id])->first();
		$child_function= ControllerFunctionName::where(['parent_function_id' => $function_id])->get();
		if(!empty($child_function)){
			foreach($child_function as $ch_fun){
				$ch_fun->permissions()->sync($request->permission);
			}				
		}		
		
		
		// $arr_parent_fun_per = array();
		// if(!empty($parent_function->permissions)){
			// foreach($parent_function->permissions as $parent_per){			
				// $arr_parent_fun_per[] = $parent_per->id;
				
				
			// }
		// }	
		// if(!empty($parent_function) && !empty($request->permission)){
			// foreach($request->permission as $req_perm){
				// if(!in_array($req_perm , $arr_parent_fun_per)){
					// $parent_function->permissions()->attach($req_perm);
				// }	
			// }
		// }
		
		// dd($arr_parent_fun_per);
		// if(!empty($parent_function) &&!empty($arr_parent_fun_per)){
			// foreach($arr_parent_fun_per as $permission){
	
				// if(!in_array($permission , $request->permission)){
					// $parent_function->permissions()->detach($permission);
				// }
			// }
		// }	
				// if(!empty($parent_function->permissions)){

		
		// if(!empty($parent_function)){
			// foreach($parent_function as $parent_fun){
				// $parent_fun->permissions()->sync($request->permission);
			// }				
		// }
		Session::flash('success', 'New permission has been Added');

        return redirect()->back()->withInput();		
		
		
		return;
	}
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   
}
