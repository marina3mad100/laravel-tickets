
@extends('layouts.app')

@section('content')
<div class="container">
	@include('partials._messages')
	@if(Auth::user()->get_permission_for_this_page_link('tickets.index'))
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">@lang('messages.filter')</div>

					<div class="card-body">

						<form action="{{route('tickets.search',app()->getLocale())}}" method="get"  >
							{{ csrf_field()}}
							<div class="row">
							<div class=" col-md-3 form-group">
								<label for="name">@lang('messages.owner')</label>
								<select class="form-control" name="user_id">
									<option value="">@lang('messages.select') @lang('messages.owner')</option>
									@if(!empty($users))
										@foreach($users as $user)
											<option value="{{$user->id}}">{{$user->name}}</option>									
										@endforeach
									@endif
									
								</select>
							</div>						

	 
							<div class="col-md-3 form-group">
								<label for="start_date">@lang('messages.fromdate') </label>
								<input type="text" class="form-control date2" name="start_date" value="" placeholder="@lang('messages.Enter') @lang('messages.fromdate')" readonly >
							</div>
							
							<div class="col-md-3 form-group">
								<label for="name">@lang('messages.todate')</label>
								<input type="text" class="form-control date2" name="end_date" value="" placeholder="@lang('messages.Enter') @lang('messages.todate')" readonly >
							</div>						
					
							<div class="col-md-3 form-group" >
								<label for="name">@lang('messages.assignedadmin')</label>
								<select class="form-control" name="user_assigned_id">
									<option value="0">@lang('messages.Ticketnotassigned')</option>
									@if(!empty($admins))
										@foreach($admins as $user)
											<option value="{{$user->id}}" >{{$user->name}}</option>									
										@endforeach
									@endif
									
								</select>
							</div>
							</div>
							<button type="submit" class="btn btn-primary">@lang('messages.filter')</button>
						  </form>      						
					</div>
				</div>
			</div>
		</div>	
	@endif
	</br></br>
	@if ($assigned_tickets->count()>0)
		<div class="row justify-content-center">	
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">@lang('messages.AssignedTicket')</div>

					<div class="card-body"> 
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
									@if(Auth::user()->get_permission_for_this_page_link('tickets.reopen')||Auth::user()->get_permission_for_this_page_link('tickets.close')||Auth::user()->get_permission_for_this_page_link('tickets.open'))
										<th>Action</th>	
									@endif
								</tr>
							</thead>
							<tbody>
								@foreach ($assigned_tickets as $ticket)
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
											<td> <a class="btn btn-primary" href="{{route('tickets.edit',[app()->getLocale() , $ticket->id ])}}">@lang('messages.edit')</a></td>
										@endif
										@if(Auth::user()->get_permission_for_this_page_link('tickets.destroy') || Auth::user()->super_admin == 1)
											<td> 
												<form action="{{route('tickets.destroy' , [app()->getLocale() ,  $ticket->id ])}}" method="POST"  >
												{{ csrf_field()}}
												{{ method_field('DELETE') }}
												<button type="submit" class="btn btn-danger">@lang('messages.delete')</button>
												</form>
											</td>
										@endif
										@if($ticket->status == 0 &&  strtotime(date('Y-m-d')) > strtotime($ticket->end_date) )
											@if(Auth::user()->get_permission_for_this_page_link('tickets.reopen'))
												<td><a class="btn btn-warning" data-toggle="modal" data-target="#modal1{{$ticket->id}}" href="{{route('tickets.reopen',[app()->getLocale() , $ticket->id ])}}">@lang('messages.reopen')</a>
												<div id="modal1{{$ticket->id}}" class="modal fade" role="dialog">
												  <div class="modal-dialog">

													<!-- Modal content-->
													<div class="modal-content">
														<form action="{{route('tickets.reopen',[app()->getLocale() , $ticket->id])}}" method="POST"  >
														{{ csrf_field()}}
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal">&times;</button>
															</div>
															<div class="modal-body">

															<div class="form-group">
																<input type="hidden" class="form-control date" name="today_date" value="{{date('Y-m-d')}}" placeholder="@lang('messages.Enter') @lang('messages.todate')" readonly >
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
												</div></td>	
											@elseif(Auth::user()->get_permission_for_this_page_link('tickets.close') || Auth::user()->get_permission_for_this_page_link('tickets.open'))

												<td></td>											
											@endif
										@elseif($ticket->status == 0 &&  strtotime($ticket->end_date) >  strtotime(date('Y-m-d')) )
											@if(Auth::user()->get_permission_for_this_page_link('tickets.open'))
												<td><a class="btn btn-success" href="{{route('tickets.open',[app()->getLocale() , $ticket->id ])}}">@lang('messages.open')</a></td>
											@elseif(Auth::user()->get_permission_for_this_page_link('tickets.close') || Auth::user()->get_permission_for_this_page_link('tickets.reopen'))

												<td></td>
											@endif
										@elseif($ticket->status == 1 || $ticket->status == 2)
											@if(Auth::user()->get_permission_for_this_page_link('tickets.close'))
												<td><a class="btn btn-danger" href="{{route('tickets.close',[app()->getLocale() , $ticket->id ])}}">@lang('messages.close')</a></td>
											@elseif(Auth::user()->get_permission_for_this_page_link('tickets.open') || Auth::user()->get_permission_for_this_page_link('tickets.reopen'))

												<td></td>																					
											@endif
										@else
											<td></td>	
										@endif										
																					
									</tr>
								@endforeach
								
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	@endif
	</br></br>	
	@if ($owned_tickets->count()>0)
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">@lang('messages.OwnedTicket')</div>
					<div class="card-body"> 		
						<table id="example2" class="table table-striped">
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
									@if(Auth::user()->get_permission_for_this_page_link('tickets.reopen')||Auth::user()->get_permission_for_this_page_link('tickets.close')||Auth::user()->get_permission_for_this_page_link('tickets.open'))
										<th>Action</th>	
									@endif							
								</tr>
							</thead>
							<tbody>
								@foreach ($owned_tickets as $ticket)
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
											<td> <a class="btn btn-primary" href="{{route('tickets.edit',[app()->getLocale() , $ticket->id ])}}">@lang('messages.edit')</a></td>
										@endif
										@if(Auth::user()->get_permission_for_this_page_link('tickets.destroy') || Auth::user()->super_admin == 1)
											<td> 
												<form action="{{route('tickets.destroy' , [app()->getLocale() ,  $ticket->id ])}}" method="POST"  >
												{{ csrf_field()}}
												{{ method_field('DELETE') }}
												<button type="submit" class="btn btn-danger">@lang('messages.delete')</button>
												</form>
											</td>
										@endif											
										@if($ticket->status == 0 &&  strtotime(date('Y-m-d')) > strtotime($ticket->end_date) )
											@if(Auth::user()->get_permission_for_this_page_link('tickets.reopen'))
												<td><a class="btn btn-warning" data-toggle="modal" data-target="#modal2{{$ticket->id}}" href="{{route('tickets.reopen',[app()->getLocale() , $ticket->id ])}}">@lang('messages.reopen')</a>
												<div id="modal2{{$ticket->id}}" class="modal fade" role="dialog">
												  <div class="modal-dialog">

													<!-- Modal content-->
													<div class="modal-content">
														<form action="{{route('tickets.reopen',[app()->getLocale() , $ticket->id])}}" method="POST"  >
														{{ csrf_field()}}
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal">&times;</button>
															</div>
															<div class="modal-body">

															<div class="form-group">
																<input type="hidden" class="form-control date" name="today_date" value="{{date('Y-m-d')}}" placeholder="@lang('messages.Enter') @lang('messages.todate')" readonly >
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
												</div></td>	
											@elseif(Auth::user()->get_permission_for_this_page_link('tickets.close') || Auth::user()->get_permission_for_this_page_link('tickets.open'))

												<td></td>											
											@endif
										@elseif($ticket->status == 0 &&  strtotime($ticket->end_date) >  strtotime(date('Y-m-d')) )
											@if(Auth::user()->get_permission_for_this_page_link('tickets.open'))
												<td><a class="btn btn-success" href="{{route('tickets.open',[app()->getLocale() , $ticket->id ])}}">@lang('messages.open')</a></td>
											@elseif(Auth::user()->get_permission_for_this_page_link('tickets.close') || Auth::user()->get_permission_for_this_page_link('tickets.reopen'))

												<td></td>
											@endif
										@elseif($ticket->status == 1 || $ticket->status == 2)
											@if(Auth::user()->get_permission_for_this_page_link('tickets.close'))
												<td><a class="btn btn-danger" href="{{route('tickets.close',[app()->getLocale() , $ticket->id ])}}">@lang('messages.close')</a></td>
											@elseif(Auth::user()->get_permission_for_this_page_link('tickets.open') || Auth::user()->get_permission_for_this_page_link('tickets.reopen'))

												<td></td>																					
											@endif
										@else
											<td></td>	
										@endif													
									</tr>
								@endforeach									
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>	
	@endif	

	</br></br>
	@if ($added_tickets_by_me->count()>0)
		<div class="row justify-content-center">	
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">@lang('messages.TicketsAddedByMe')</div>

					<div class="card-body"> 
						<table id="example3" class="table table-striped">
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
									@if(Auth::user()->get_permission_for_this_page_link('tickets.reopen')||Auth::user()->get_permission_for_this_page_link('tickets.close')||Auth::user()->get_permission_for_this_page_link('tickets.open'))
										<th>Action</th>	
									@endif
								</tr>
							</thead>
							<tbody>
								@foreach ($added_tickets_by_me as $ticket)
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
											<td> <a class="btn btn-primary" href="{{route('tickets.edit',[app()->getLocale() , $ticket->id ])}}">@lang('messages.edit')</a></td>
										@endif
										@if(Auth::user()->get_permission_for_this_page_link('tickets.destroy') || Auth::user()->super_admin == 1)
											<td> 
												<form action="{{route('tickets.destroy' , [app()->getLocale() ,  $ticket->id ])}}" method="POST"  >
												{{ csrf_field()}}
												{{ method_field('DELETE') }}
												<button type="submit" class="btn btn-danger">@lang('messages.delete')</button>
												</form>
											</td>
										@endif

										@if($ticket->status == 0 &&  strtotime(date('Y-m-d')) > strtotime($ticket->end_date) )
											@if(Auth::user()->get_permission_for_this_page_link('tickets.reopen'))
												<td><a class="btn btn-warning" data-toggle="modal" data-target="#modal3{{$ticket->id}}" href="{{route('tickets.reopen',[app()->getLocale() , $ticket->id ])}}">@lang('messages.reopen')</a>
												<div id="modal3{{$ticket->id}}" class="modal fade" role="dialog">
												  <div class="modal-dialog">

													<!-- Modal content-->
													<div class="modal-content">
														<form action="{{route('tickets.reopen',[app()->getLocale() , $ticket->id])}}" method="POST"  >
														{{ csrf_field()}}
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal">&times;</button>
															</div>
															<div class="modal-body">

															<div class="form-group">
																<input type="hidden" class="form-control date" name="today_date" value="{{date('Y-m-d')}}" placeholder="@lang('messages.Enter') @lang('messages.todate')" readonly >
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
												</div></td>	
											@elseif(Auth::user()->get_permission_for_this_page_link('tickets.close') || Auth::user()->get_permission_for_this_page_link('tickets.open'))
												<td></td>											
											@endif
										@elseif($ticket->status == 0 &&  strtotime($ticket->end_date) >  strtotime(date('Y-m-d')) )
											@if(Auth::user()->get_permission_for_this_page_link('tickets.open'))
												<td><a class="btn btn-success" href="{{route('tickets.open',[app()->getLocale() , $ticket->id ])}}">@lang('messages.open')</a></td>
											@elseif(Auth::user()->get_permission_for_this_page_link('tickets.close') || Auth::user()->get_permission_for_this_page_link('tickets.reopen'))
												<td></td>
											@endif
										@elseif($ticket->status == 1 || $ticket->status == 2)
											@if(Auth::user()->get_permission_for_this_page_link('tickets.close'))
												<td><a class="btn btn-danger" href="{{route('tickets.close',[app()->getLocale() , $ticket->id ])}}">@lang('messages.close')</a></td>
											@elseif(Auth::user()->get_permission_for_this_page_link('tickets.open') || Auth::user()->get_permission_for_this_page_link('tickets.reopen'))
												<td></td>																				
											@endif
										@else
											<td></td>		
										@endif												
									</tr>
								@endforeach
								
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	@endif
	
    </div>
</div>
@endsection


											
	
