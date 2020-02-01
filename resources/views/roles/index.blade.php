@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('messages.Roles')</div>

                <div class="card-body">
					@include('partials._messages')
 
                    @if ($roles->count()>0)                                                                          
                        <table id="example" class="table table-striped">
							<thead>
							  <tr>
								<th scope="col"> @lang('messages.RoleTitle') </th>
								<th scope="col"> @lang('messages.Permissions') </th>
								@if(Auth::user()->get_permission_for_this_page_link('roles.edit') || Auth::user()->super_admin == 1)
									<th scope="col">@lang('messages.edit')</th>
								@endif
								@if(Auth::user()->get_permission_for_this_page_link('roles.destroy') || Auth::user()->super_admin == 1)
									<th scope="col">@lang('messages.delete')</th>
								@endif								
							  </tr>
							</thead>
							<tbody>
								@foreach ($roles as $role)
									<tr>
										<td> {{$role->name}}</td>
										<td>
											@if($role->permissions->count() > 0)
												@foreach($role->permissions as $permission)
													<span class="badge">{{$permission->name}}</span>
												@endforeach
											
											@endif
										</td>										
										@if(Auth::user()->get_permission_for_this_page_link('roles.edit') || Auth::user()->super_admin == 1)	
											<td>
												@if($role->name != 'Super Admin')
													<a class="btn btn-primary" href="{{route('roles.edit',[app()->getLocale() , $role->id ])}}"> @lang('messages.edit')</a> 													
												@endif
											</td>
										@endif	
										@if(Auth::user()->get_permission_for_this_page_link('roles.destroy') || Auth::user()->super_admin == 1)
											<td> 
												@if($role->name != 'Super Admin')
													<form action="{{route('roles.destroy' , [app()->getLocale() , $role->id ])}}" method="POST"  >
													{{ csrf_field()}}
													{{ method_field('DELETE') }}
													<button type="submit" class="btn btn-danger">@lang('messages.delete')</button>
													</form>
												@endif
										   </td>
										@endif   
									</tr>
								@endforeach								
							</tbody>
						</table>
					@endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
