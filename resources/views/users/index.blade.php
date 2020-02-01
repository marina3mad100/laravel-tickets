@extends('layouts.app')

@section('content')






<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('messages.ِِAllAdmins')</div>

                <div class="card-body">
 
					@include('partials._messages') 
                    @if ($admins->count()>0)                                   
                        <table id="example" class="table table-striped">
							<thead>
								<tr>
									<th scope="col"> @lang('messages.Name') </th>
									<th scope="col">@lang('messages.E-Mail Address')</th>
									<th scope="col">@lang('messages.Roles')</th>
									<th scope="col">@lang('messages.Permissions')</th>
									@if(Auth::user()->get_permission_for_this_page_link('admins.edit') || Auth::user()->super_admin == 1)
										<th scope="col">@lang('messages.edit')</th>
									@endif
									@if(Auth::user()->get_permission_for_this_page_link('admins.destroy') || Auth::user()->super_admin == 1)
										<th scope="col">@lang('messages.delete')</th>
									@endif								
							  </tr>
							</thead>
							<tbody>
								@foreach ($admins as $admin)
								<tr>
									<td>{{$admin->name}} </td>
									<td>{{$admin->email}} </td>
									<td>
										@if($admin->getRoleNames()->count() > 0)
											@foreach($admin->getRoleNames() as $role)
												<span class="badge"  data-toggle="modal" data-target="#{{$role}}">{{$role}}</span>																																			
											@endforeach
										
										@endif										

									</td>
									<td>
										@if($admin->getAllPermissions()->count() > 0)
											@foreach($admin->getAllPermissions() as $permission)
												<span class="badge">{{$permission->name}}</span>											
											@endforeach										
										@endif										
									</td>										
									@if(Auth::user()->get_permission_for_this_page_link('admins.edit') || Auth::user()->super_admin == 1)
										<td> <a class="btn btn-primary" href="{{route('admins.edit',[app()->getLocale() , $admin->id ])}}"> @lang('messages.edit')</a> </td>
									@endif
									@if(Auth::user()->get_permission_for_this_page_link('admins.destroy') || Auth::user()->super_admin == 1)	
										<td> 
											<form action="{{route('admins.destroy' , [app()->getLocale() ,  $admin->id ])}}" method="POST"  >
											{{ csrf_field()}}
											{{ method_field('DELETE') }}
											<button type="submit" class="btn btn-danger">@lang('messages.delete')</button>
											</form>
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
