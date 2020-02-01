@if (Session::has('success'))
	
	<div class="alert alert-success" role="alert">
	<?php
		echo Lang::get('messages.'.Session::get('success'));
	?>
	</div>

@endif

@if (count($errors) > 0)

	<div class="alert alert-danger" role="alert">
		<strong>@lang('messages.Errors'):</strong>
		<ul>
		@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach  
		</ul>
	</div>

@endif