@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
					<?php
						echo Lang::get('messages.Dashboard');
					?>
				</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif                    
					<?php
						echo Lang::get('messages.You are logged in as');
					?>					
					@if(Auth::user())
						@if(Auth::user()->is_owner())
							<h2>OWNER</h2>
						@elseif(Auth::user()->super_admin == 1)
							<h2>SUPER ADMIN</h2>
						@else
							<h2>ADMIN</h2>
						@endif						
					@endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
