@extends('layouts.app')

@section('content')






<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('messages.SiteFunction')</div>

                <div class="card-body">
 
					@include('partials._messages') 
                    @if ($controller_function->count()>0)                                   
                        <table id="example" class="table table-striped">
							<thead>
							  <tr>
								 <th scope="col">@lang('messages.FunctionName')</th>
								 <th scope="col">@lang('messages.Permissions')</th>
								
							  </tr>
							</thead>
							<tbody>
								@foreach ($controller_function as $function)
							
										<tr>
											<td>{{$function->name}} </td>
											<td>
												<form action="{{route('functions.add_delete' , [app()->getLocale() , $function->id ])}}" method="POST"  >
													{{ csrf_field()}}
										
													<div class="form-check">
														@if ($permissions->count()>0)
															@foreach ($permissions as $permission)								
															<input class="form-check-input" type="checkbox" id="role{{$permission->id}}" name="permission[]" value="{{$permission->id}}"
																@if(!empty($function->permissions))
																	@foreach($function->permissions as $fun_perm){
																		@if($fun_perm->id == $permission->id)
																			checked
																		@endif	
																
																	@endforeach
																		
																
																@endif
															>
															<label class="form-check-label"  >
																	{{$permission->name}}
																  </label><br>
															@endforeach
														@endif
														
													</div>
													<button type="submit" class="btn btn-danger">@lang('messages.save')</button>
		
												</form>
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
