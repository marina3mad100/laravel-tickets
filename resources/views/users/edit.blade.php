@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('messages.Edit') </div>
				@include('partials._messages')

                <div class="card-body">
					<form action="{{route('admins.update' , [app()->getLocale() ,  $admin->id ])}}" method="POST"  >
                        @csrf
						{{ method_field('PUT') }}
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">@lang('messages.Name')</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="@if ($errors->any()){{old('name')}} @else{{$admin->name}}  @endif"  autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">@lang('messages.E-Mail Address')</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="@if ($errors->any()) {{old('email')}} @else {{$admin->email}}  @endif" >

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">@lang('messages.Password')</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" >

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">@lang('messages.Confirm Password')</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" >
                            </div>
                        </div>
						
						<div class="form-group row">
							<label for="role" class="col-md-4 col-form-label text-md-right">@lang('messages.Role') </label>

							<div class="form-check">
								@if ($roles->count()>0)
									@foreach ($roles as $role)								
									<input class="form-check-input" type="checkbox" id="role{{$role->id}}" name="role[]" value="{{$role->id}}" 
									@if(in_array($role->id,$admin_roles))
										checked
									@endif
									>
									<label class="form-check-label"  >
											{{$role->name}}
										  </label><br>
									@endforeach
								@endif
								
							</div>								
						</div>


						<div class="form-group row">
							<label for="permission" class="col-md-4 col-form-label text-md-right">@lang('messages.Permission') </label>

							<div class="form-check">
								@if ($permisions->count()>0)
									@foreach ($permisions as $permission)								
									<input class="form-check-input" type="checkbox" id="role{{$permission->id}}" name="permission[]" value="{{$permission->id}}"  
									@if(in_array($permission->id,$admin_premissions))
										checked
									@endif
									>
									<label class="form-check-label"  >
											{{$permission->name}}
										  </label><br>
									@endforeach
								@endif
								
							</div>								
						</div>

					
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    @lang('messages.save') 
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
