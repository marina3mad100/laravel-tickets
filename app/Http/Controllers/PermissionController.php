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
		]);
		$roles = $request->role ;
        $permission = Permission::create(['name' => preg_replace('/[^A-Za-z0-9\-]/', ' ', $request->permission)]);
		if(isset($roles) && !empty($roles)){
			$permission->syncRoles($roles);		
		}
		Session::flash('success', 'New Permission has been created');
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
        $this->validate($request,[
			'permission' => 'required|unique:permissions,name,'.$id,
		]);
		$permission->name = preg_replace('/[^A-Za-z0-9\-]/', ' ', $request->permission);
		$permission->save();
		
		$permission->syncRoles($request->role);				
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
