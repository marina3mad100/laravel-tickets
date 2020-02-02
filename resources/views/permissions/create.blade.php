@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('messages.CreatePermission')</div>
                <div class="card-body">
					@include('partials._messages')                   
                    <form action="{{route('permissions.store',app()->getLocale())}}" method="POST"  >
                        {{ csrf_field()}}
                        <div class="form-group">
							<label for="name">@lang('messages.PermissionName')</label>
							<input type="text" class="form-control" name="permission" value="@if ($errors->any()) {{old('permission')}} @elseif (Session::has('success')) {{''}}  @endif" placeholder="@lang('messages.Enter') @lang('messages.PermissionName')">
                        </div>                       
                        <div class="form-group">
                            <label for="role">@lang('messages.Roles')</label>

							<div class="form-check">
								@if ($roles->count()>0)
									@foreach ($roles as $role)								
									<input class="form-check-input" type="checkbox" name="role[]" value="{{$role->id}}"  >
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
