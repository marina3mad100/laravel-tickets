<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Session; 
use App\Http\Requests\CreateRuleRequest;
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('roles.index')->with('roles',Role::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('roles.create');
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
            'role' => 'required|unique:roles,name'
        ]);
        $role = Role::create(['name' => preg_replace('/[^A-Za-z0-9\-]/', ' ', $request->role)]);
		Session::flash('success', 'New Role has been created');
		return redirect()->route('roles.index',$locale);

        // return redirect()->back()->withInput();
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
        $role = Role::find($id);
        return view('roles.edit')->with('role',$role);
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
        $role = Role::find($id);
        $this->validate($request,[
            'role' => 'required|unique:roles,name,'.$id
        ]);
		$role->name = $request->role;
		$role->save();
		Session::flash('success', 'Role Has Been Updated');

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
        //
        $role = Role::find($id);
		$permissions = $role->permissions;	
		$role->revokePermissionTo($permissions);
		$role->users()->detach();
		$role->delete();
		Session::flash('success', 'Role Has Been Deleted');
		return redirect()->route('roles.index',$locale);	

		
    }
}
