@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('messages.Permissions')</div>

                <div class="card-body"> 
				    @include('partials._messages')                
                    @if ($permissions->count()>0)
                                    
                        <table id="example" class="table table-striped">
                                <thead>
                                  <tr>
                                    <th scope="col"> @lang('messages.title') </th>
                                    <th scope="col">@lang('messages.Roles')</th>
									@if(Auth::user()->get_permission_for_this_page_link('permissions.edit') || Auth::user()->super_admin == 1)
										<th scope="col">@lang('messages.edit')</th>
									@endif
									@if(Auth::user()->get_permission_for_this_page_link('permissions.destroy') || Auth::user()->super_admin == 1)
										<th scope="col">@lang('messages.delete')</th>
									@endif	                                   
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $permission)
										<tr>
											<td> {{$permission->name}} </td>
											<td>
											@if($permission->roles->count() > 0)
												@foreach($permission->roles as $role)
													<span class="badge">{{$role->name}}</span>
												@endforeach
											
											@endif
											</td>
											@if(Auth::user()->get_permission_for_this_page_link('permissions.edit') || Auth::user()->super_admin == 1)	
												<td> <a class="btn btn-primary" href="{{route('permissions.edit',[app()->getLocale() , $permission->id ])}}">@lang('messages.edit')</a></td>
											@endif
											@if(Auth::user()->get_permission_for_this_page_link('permissions.destroy') || Auth::user()->super_admin == 1)
												<td> 
													<form action="{{route('permissions.destroy' , [app()->getLocale() ,  $permission->id ])}}" method="POST"  >
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
