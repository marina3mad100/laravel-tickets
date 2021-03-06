<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Session;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	 
	public function __construct()
    {
        $this->middleware('auth');
    }

	
    public function index()
    {
		
		$admins = User::where('id', '!=', Auth::user()->id)
           ->where(function ($query) {
               $query->where('super_admin', '=', 1)
                     ->orWhere('admin', '=', 1);
           })
           ->get();			
        return view('users.index')->with('admins',$admins);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

	
	public function create()
    {
        return view('users.create')->with('roles',Role::all())->with('permisions',Permission::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($locale ,Request $request)
    {
        $this->validate($request,[
            'name' => 'required|unique:users,name|max:150|string',
			'email' => 'required|string|email|max:150|unique:users,email',
			'password' => 'required|string|min:6|confirmed',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
			
        ]);

		$user_row = User::find($user->id);
		$roles = $request->role ;
		if(!empty($request->role)){

			$user_row->syncRoles($roles);

		}
		$super_admin = 0;		
		if(!empty($user->roles)){
			
			foreach($user->roles as $rolename){
				if($rolename->name == 'Super Admin'){
					$user->super_admin = 1;
					$user->admin = 0;
					$super_admin = 1;
					$user->save();
					break;
				}
					
			}
			if($super_admin == 0){
				$user->admin = 1;
				$user->super_admin = 0;				
				$user->save();				
			}
			
		}
		
		if(!empty($request->permission)){
			$user_row->syncPermissions($request->permission);
			
		}
		Session::flash('success', 'New Admin has been created');

        return redirect()->back()->withInput();
		//return redirect()->route('admins.index',$locale);
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
    public function edit($locale ,$id)
    {
		$admin = User::find($id);
		//get admin roles id
		$admin_roles = array();
		if(!empty($admin->roles)){
			foreach($admin->roles as $role){
				$admin_roles[] = $role->id;
			}
		}	
		//get admin direct permission id
		$admin_premissions = array();
		if(!empty($admin->permissions)){
			foreach($admin->permissions as $permission){
				$admin_premissions[] = $permission->id;
			}
		}

        return view('users.edit')->with('admin',$admin)
		->with('admin_roles',$admin_roles)
		->with('admin_premissions',$admin_premissions)
		->with('roles',Role::all())->with('permisions',Permission::all());

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($locale ,Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required|unique:users,name,'.$id.'|max:150|string',
			'email' => 'required|string|email|max:150|unique:users,email,'.$id,
			'password' => 'required|string|min:6|confirmed',
        ]);
		
		$user = User::find($id);
		$user->name=$request->name;
        $user->email=$request->email;
		$user->password =Hash::make($request->password);
		$user->save();		
		$roles = $request->role ;
		$user->syncRoles($roles);
		
		$super_admin = 0;		
		if(!empty($user->roles)){			
			foreach($user->roles as $rolename){
				if($rolename->name == 'Super Admin'){
					$user->super_admin = 1;
					$user->admin = 0;
					$super_admin = 1;
					$user->save();
					break;
				}
					
			}
			if($super_admin == 0){
				$user->admin = 1;
				$user->super_admin = 0;				
				$user->save();				
			}
			
		}						
		$user->syncPermissions($request->permission);			
		Session::flash('success', 'Admin has been updated');
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
        $user = User::find($id);
		$roles = $user->roles;		
		if(!empty($roles)){
			foreach($roles as $role){
				$user->removeRole($role->name);
			}
		}		
		$permissions = $user->permissions;		
		if(!empty($permissions)){
			foreach($permissions as $permission){
				$user->revokePermissionTo($permission->name);
			}
		}		
		$user->tickets()->delete();
		$user->delete();
		Session::flash('success', 'Admin Has Been Deleted');
		return redirect()->route('admins.index',$locale);		
		
    }
}
