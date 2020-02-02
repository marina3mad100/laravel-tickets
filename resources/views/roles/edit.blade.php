@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('messages.EditRole')</div>
                <div class="card-body">
					@include('partials._messages')                  
                    <form action="{{route('roles.update' , [app()->getLocale() ,  $role->id ])}}" method="POST"  >
                        {{ csrf_field()}}
						{{ method_field('PUT') }}
                        <div class="form-group">
							<label for="name">@lang('messages.RoleName')</label>
							<input type="text" class="form-control" name="role" value="@if ($errors->any()) {{old('role')}} @else {{$role->name}}  @endif"  placeholder="@lang('messages.Enter') @lang('messages.RoleName')">
                        </div>
                        <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
                    </form>      
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
