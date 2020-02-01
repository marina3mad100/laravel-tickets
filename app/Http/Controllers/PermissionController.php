<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Session; 
class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		// dd(Permission::with('roles')->get());
        return view('permissions.index')->with('permissions',Permission::with('roles')->get());

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('permissions.create')->with('roles',Role::where('name','!=','Super Admin')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($locale , Request $request)
    {
        $this->validate($request,[
			'permission' => 'required|unique:permissions,name',
			//'role' => 'required'
		]);
		
		$roles = $request->role ;
        $permission = Permission::create(['name' => preg_replace('/[^A-Za-z0-9\-]/', ' ', $request->permission)]);
		if(isset($roles) && !empty($roles)){
			$permission->syncRoles($roles);		
		}
		Session::flash('success', 'New Permission has been created');
        //return redirect()->back()->withInput();
		return redirect()->route('permissions.index',$locale);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($local,$id)
    {
        $permission = Permission::find($id);
        return view('permissions.edit')->with('permission',$permission)->with('roles',Role::where('name','!=','Super Admin')->get());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($locale,Request $request, $id)
    {
		
        $permission = Permission::find($id);
		// dd($permission->roles);

        $this->validate($request,[
			'permission' => 'required|unique:permissions,name,'.$id,
		]);
		$permission->name = preg_replace('/[^A-Za-z0-9\-]/', ' ', $request->permission);
		$permission->save();
		
		$perm_roles = array();
		if($permission->roles->count() > 0){
			foreach($permission->roles as $role){
					$perm_roles[]=$role->id;
				
				
			}
		}
		
		$new_roles = array();
		if(!empty($request->role)){
			foreach($request->role as $role){
				
				if(!in_array($role,$perm_roles)){
					$new_roles[]=$role;
				}
				
			}
			
		}

		if(!empty($new_roles)){
			$permission->assignRole($new_roles);
		}
		
		Session::flash('success', 'Permission Has Been Updated');

        return redirect()->back()->withInput();	
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($locale ,$id)
    {
        $permission = Permission::find($id);
		$roles = Permission::with('roles')->get();
		if(!empty($roles)){
			foreach($roles as $role){
				$role->users()->detach();
				//$permission->removeRole($role);
			}
		}
		
		$permission->roles()->detach();
		$permission->users()->detach();
		$permission->delete();
		Session::flash('success', 'Permission Has Been Deleted');
		return redirect()->route('permissions.index',$locale);
    }
}
