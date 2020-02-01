@extends('layouts.app')

@section('content')






<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('messages.EditPermission')</div>

                <div class="card-body">

					@include('partials._messages')

                    

					<form action="{{route('permissions.update' , [app()->getLocale() ,  $permission->id ])}}" method="POST"  >
                        {{ csrf_field()}}
						{{ method_field('PUT') }}
                        <div class="form-group">
                          <label for="name">@lang('messages.PermissionName')</label>
                          <input type="text" class="form-control" name="permission" value="@if ($errors->any()) {{old('permission')}} @else {{$permission->name}}  @endif"  placeholder="@lang('messages.Enter') @lang('messages.PermissionName')">
                         </div>
                        
                        <div class="form-group">
                            <label for="role">@lang('messages.Roles')</label>

							<div class="form-check">
								@if ($roles->count()>0)
									@foreach ($roles as $role)								
									<input class="form-check-input" type="checkbox" name="role[]" value="{{$role->id}}" 
									@if($permission->roles->count() > 0) 
										@foreach($permission->roles as $p_role)
											@if($p_role->id == $role->id)
												checked
											@endif
										@endforeach
												
									@endif  />
									<label class="form-check-label"  >
											{{$role->name}}
										  </label><br>
									@endforeach
								@endif
								
							  </div>							
							
					
                         </div>                         
                         
                        <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
                      </form>      
                    







                </div>
            </div>
        </div>
    </div>
</div>
@endsection
