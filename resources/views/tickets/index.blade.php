@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">@lang('messages.AllTickets')</div>
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
									<th scope="col">@lang('messages.description')</th>										
									<th scope="col">@lang('messages.status')</th>
									@if(Auth::user()->get_permission_for_this_page_link('tickets.edit') || Auth::user()->super_admin == 1)
										<th scope="col">@lang('messages.edit')</th>
									@endif
									@if(Auth::user()->get_permission_for_this_page_link('tickets.destroy') || Auth::user()->super_admin == 1)
										<th scope="col">@lang('messages.delete')</th>
									@endif	
									<th>Action</th>
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
										<td> {{$ticket->description}} </td>											
										<td>
											@if($ticket->status == 0)
												<span class="badge">@lang('messages.Closed')</span>
											@elseif($ticket->status == 1)
												<span class="badge" style="background:green;">@lang('messages.Opened')</span>	
											@elseif($ticket->status == 2)
												<span class="badge" style="background:orange;">@lang('messages.ReOpened')</span>														
											@endif
										</td>
										
									
										@if(Auth::user()->get_permission_for_this_page_link('tickets.edit') || Auth::user()->super_admin == 1)	
											<td> <a class="btn btn-primary" href="{{route('tickets.edit',[app()->getLocale() ,$ticket->id ])}}">@lang('messages.edit')</a></td>
										@endif
										@if(Auth::user()->get_permission_for_this_page_link('tickets.destroy') || Auth::user()->super_admin == 1)
											<td> 
												<form action="{{route('tickets.destroy' , [app()->getLocale() , $ticket->id ])}}" method="POST"  >
												{{ csrf_field()}}
												{{ method_field('DELETE') }}
												<button type="submit" class="btn btn-danger">@lang('messages.delete')</button>
												</form>
											</td>
										@endif

										<td>
											@if($ticket->status == 0 &&  strtotime(date('Y-m-d')) > strtotime($ticket->end_date) )
												@if(Auth::user()->get_permission_for_this_page_link('tickets.reopen'))
												<a class="btn btn-warning" data-toggle="modal" data-target="#modal{{$ticket->id}}" href="{{route('tickets.reopen',[app()->getLocale() , $ticket->id ])}}">@lang('messages.reopen')</a>
												<div id="modal{{$ticket->id}}" class="modal fade" role="dialog">
												  <div class="modal-dialog">

													<!-- Modal content-->
													<div class="modal-content">
														<form action="{{route('tickets.reopen',[app()->getLocale() , $ticket->id])}}" method="POST"  >
														{{ csrf_field()}}
															<div class="modal-header">
																<h4>@lang('messages.ReOpen Ticket No')  {{$ticket->ticket_no}}</h4>															
																<button type="button" class="close" data-dismiss="modal">&times;</button>
															</div>
															<div class="modal-body">

															<div class="form-group">
																<input type="hidden" class="form-control date" name="today_date" value="{{date('Y-m-d')}}" placeholder="Enter To Date" readonly >
																<label for="name">@lang('messages.ReopenToDate')</label>
																<input type="text" class="form-control date" name="reopen_end_date" value="@if ($errors->any()) {{old('end_date')}}    @endif" placeholder="@lang('messages.Enter') @lang('messages.todate')" readonly >
															</div>	
															</div>
															<div class="modal-footer">
																<button type="submit" class="btn btn-primary">@lang('messages.save')</button>
																<button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.close')</button>
															</div>
														</form>
													</div>

												  </div>
												</div>												
											
												@endif
											@elseif($ticket->status == 0 &&  strtotime($ticket->end_date) >  strtotime(date('Y-m-d')) )
												@if(Auth::user()->get_permission_for_this_page_link('tickets.open'))
												<a class="btn btn-success" href="{{route('tickets.open',[app()->getLocale() , $ticket->id ])}}">@lang('messages.open')</a>
												@endif
											@elseif($ticket->status == 1 || $ticket->status == 2)
												@if(Auth::user()->get_permission_for_this_page_link('tickets.close'))
												<a class="btn btn-danger" href="{{route('tickets.close',[app()->getLocale() , $ticket->id ])}}">@lang('messages.close')</a>
												@endif
												
											@endif										
										</td>	
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
