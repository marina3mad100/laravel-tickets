
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">@lang('messages.AssignedTicket')</div>

                <div class="card-body"> 
				    @include('partials._messages')                
                    @if ($tickets->count()>0)
                                    
                        <table id="example" class="table table-striped">
                                <thead>
                                  <tr>
									<th scope="col">@lang('messages.TicketNo') </th>
									<th scope="col">@lang('messages.owner')</th>
									<th scope="col">@lang('messages.fromdate')</th>
									<th scope="col">@lang('messages.todate')</th>
									<th scope="col">@lang('messages.assignedadmin')</th>
									<th scope="col">@lang('messages.status')</th>
									<th scope="col">@lang('messages.description')</th>																			
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tickets as $ticket)
										<tr>
											<td> {{$ticket->ticket_no}} </td>
											<td> {{$ticket->user->name}} </td>
											<td> {{$ticket->start_date}} </td>
											<td> {{$ticket->end_date}} </td>
											<td> 
												@if(isset($ticket->assigned_admin->name))
													{{$ticket->assigned_admin->name}}
												@endif
											</td>
											<td>
												@if($ticket->status == 0)
													<span class="badge">@lang('messages.Closed')</span>
												@elseif($ticket->status == 1)
													<span class="badge" style="background:green;">@lang('messages.Opened')</span>	
												@elseif($ticket->status == 2)
													<span class="badge" style="background:orange;">@lang('messages.Reopened')</span>														
												@endif
											</td>
											<td> {{$ticket->description}} </td>											
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


											
	
