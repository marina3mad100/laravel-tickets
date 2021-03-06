@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('messages.TicketCreate')</div>
                <div class="card-body">
					@include('partials._messages')
                    <form action="{{route('tickets.store' , app()->getLocale())}}" method="POST"  >
                        {{ csrf_field()}}
						<div class="form-group">
							<label for="name">@lang('messages.owner')</label>
							<select class="form-control" name="user_id">
								@if(!empty($users))
									@foreach($users as $user)
										<option value="{{$user->id}}" @if ($errors->any()&& old('user_id') == $user->id ) {{'selected'}} @elseif (Session::has('success')) {{''}}  @endif>{{$user->name}}</option>									
									@endforeach
								@endif
								
							</select>
                        </div>						
                        <div class="form-group">
							<label for="name">@lang('messages.TicketNo')</label>
							<input type="text" class="form-control" name="ticket_no" value="@if ($errors->any()) {{old('ticket_no')}} @elseif (Session::has('success')) {{''}}  @endif" placeholder="@lang('messages.Enter') @lang('messages.TicketNo')">
                        </div>
 
                        <div class="form-group">
							<label for="name">@lang('messages.fromdate') (@lang('messages.currentdate'))</label>
							<input type="text" class="form-control" name="start_date" value="@if ($errors->any()) {{old('start_date')}} @else {{date('Y-m-d')}}  @endif" placeholder="@lang('messages.Enter') @lang('messages.fromdate')"readonly >
                        </div>
                        <div class="form-group">
							<label for="name">@lang('messages.todate')</label>
							<input type="text" class="form-control date" name="end_date" value="@if ($errors->any()) {{old('end_date')}} @else {{date('Y-m-d')}}  @endif" placeholder="@lang('messages.Enter') @lang('messages.todate')" readonly >
                        </div>						
						<div class="form-group">
							<label for="name">@lang('messages.description')</label>
							<textarea name="description" class="form-control">@if ($errors->any()) {{old('description')}} @elseif (Session::has('success')) {{''}}  @endif</textarea>
                        </div>						
	                    <div class="form-group" >
							<label for="name">@lang('messages.assignedadmin')</label>
							<select class="form-control" name="user_assigned_id">
								<option value="">@lang('messages.select') @lang('messages.Admins')</option>
								@if(!empty($admins))
									@foreach($admins as $user)
										<option value="{{$user->id}}" @if ($errors->any() && old('user_assigned_id') == $user->id ) {{'selected'}} @elseif (Session::has('success')) {{''}}  @endif >{{$user->name}}</option>									
									@endforeach
								@endif								
							</select>
                        </div>  
                        <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
                      </form>                         
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
