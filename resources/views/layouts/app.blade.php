<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
	<script src="{{ asset('js/app.js') }}" ></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
	
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
				@if (Auth::user())
					@if(Auth::user()->is_owner())
						<a class="navbar-brand" href="{{ url('/') }}">@lang('messages.TicketsSys')</a>
					@else
						<a class="navbar-brand" href="{{route('tickets.dashboard' ,[ app()->getLocale(), Auth::user()->id])}}">@lang('messages.DashboardTickets')</a>
					
					@endif
				@endif	
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
					@if (Auth::user())




					@if(Auth::user()->get_permission_for_this_page_link('roles.index') || Auth::user()->get_permission_for_this_page_link('roles.create') || Auth::user()->get_permission_for_this_page_link('roles.edit') || Auth::user()->get_permission_for_this_page_link('roles.destroy') ||  Auth::user()->super_admin == 1)  
						<ul class="navbar-nav mr-auto">
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									@lang('messages.Roles')
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdown">
									@if(Auth::user()->get_permission_for_this_page_link('roles.create') || Auth::user()->super_admin == 1)
										<a class="dropdown-item" href="{{route('roles.create',app()->getLocale())}}">@lang('messages.CreateRole')</a>
									@endif
									@if(Auth::user()->get_permission_for_this_page_link('roles.index') || Auth::user()->get_permission_for_this_page_link('roles.edit') || Auth::user()->get_permission_for_this_page_link('roles.destroy') || Auth::user()->get_permission_for_this_page_link('roles.create') ||  Auth::user()->super_admin == 1)
										<a class="dropdown-item" href="{{route('roles.index',app()->getLocale())}}">@lang('messages.AllRoles')</a>
									@endif
						
								</div>
							</li>
						
						</ul>
					@endif	
					@if(Auth::user()->get_permission_for_this_page_link('permissions.index') || Auth::user()->get_permission_for_this_page_link('permissions.create') || Auth::user()->get_permission_for_this_page_link('permissions.edit') || Auth::user()->get_permission_for_this_page_link('permissions.destroy') || Auth::user()->super_admin == 1)  
						<ul class="navbar-nav mr-auto">
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								@lang('messages.Permissions')
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdown">
									@if(Auth::user()->get_permission_for_this_page_link('permissions.create') || Auth::user()->super_admin == 1)
										<a class="dropdown-item" href="{{route('permissions.create',app()->getLocale())}}">@lang('messages.CreatePermission')</a>	
									@endif
									@if(Auth::user()->get_permission_for_this_page_link('permissions.index') || Auth::user()->get_permission_for_this_page_link('permissions.edit') || Auth::user()->get_permission_for_this_page_link('permissions.destroy') || Auth::user()->get_permission_for_this_page_link('permissions.create') || Auth::user()->super_admin == 1)
										<a class="dropdown-item" href="{{route('permissions.index',app()->getLocale())}}">@lang('messages.AllPermissions')</a>																	
									@endif
					
							  </div>
							</li>
							
						  </ul>
					@endif
					@if(Auth::user()->get_permission_for_this_page_link('admins.index') || Auth::user()->get_permission_for_this_page_link('admins.create') || Auth::user()->get_permission_for_this_page_link('admins.edit') || Auth::user()->get_permission_for_this_page_link('admins.destroy') ||  Auth::user()->super_admin == 1)  
						<ul class="navbar-nav mr-auto">
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									@lang('messages.Admins')
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdown">
									@if(Auth::user()->get_permission_for_this_page_link('admins.create') || Auth::user()->super_admin == 1)
										<a class="dropdown-item" href="{{route('admins.create',app()->getLocale())}}">@lang('messages.CreateAdmin')</a>	
									@endif
									@if(Auth::user()->get_permission_for_this_page_link('admins.index') || Auth::user()->get_permission_for_this_page_link('admins.edit') || Auth::user()->get_permission_for_this_page_link('admins.destroy') || Auth::user()->super_admin == 1)
										<a class="dropdown-item" href="{{route('admins.index',app()->getLocale())}}">@lang('messages.AllAdmins')</a>																	
									@endif
					
							  </div>									

							</li>
						
						</ul>	
					@endif 
					@if(Auth::user()->get_permission_for_this_page_link('functions.show')  || Auth::user()->super_admin == 1)  						
						<ul class="navbar-nav mr-auto">
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									@lang('messages.SiteFunction')
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdown">
									@if(Auth::user()->get_permission_for_this_page_link('functions.show') || Auth::user()->super_admin == 1)
										<a class="dropdown-item" href="{{route('functions.show' ,app()->getLocale())}}">@lang('messages.SiteFunPermission')</a>
									@endif
								</div>
							</li>
						
					   </ul>	
					@endif 
					@if(Auth::user()->get_permission_for_this_page_link('tickets.create') || Auth::user()->get_permission_for_this_page_link('tickets.index') || Auth::user()->get_permission_for_this_page_link('tickets.edit') || Auth::user()->get_permission_for_this_page_link('tickets.destroy')  || Auth::user()->super_admin == 1 || Auth::user()->is_owner() == 1)  						

						<ul class="navbar-nav mr-auto">
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									@lang('messages.Tickets')
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdown">
									@if(Auth::user()->get_permission_for_this_page_link('tickets.create') || Auth::user()->super_admin == 1 )
										<a class="dropdown-item" href="{{route('tickets.create',app()->getLocale())}}">@lang('messages.CreateTickets')</a>	
										<a class="dropdown-item" href="{{route('tickets.mytickets' ,[app()->getLocale(),Auth::user()->id])}}">@lang('messages.MyTickets')</a>
									
									@endif
									@if(Auth::user()->get_permission_for_this_page_link('tickets.index') || Auth::user()->super_admin == 1)
										<a class="dropdown-item" href="{{route('tickets.index',app()->getLocale())}}">@lang('messages.AllTickets')</a>																	
									@endif

									@if(Auth::user()->is_owner())
										<a class="dropdown-item" href="{{route('tickets.addticket',app()->getLocale())}}">@lang('messages.CreateTickets')</a>	
										<a class="dropdown-item" href="{{route('tickets.ownertickets' ,[ app()->getLocale(),Auth::user()->id])}}">@lang('messages.MyTickets')</a>
																				
									@endif

								
									
					
							  </div>									

							</li>
						
						</ul>	
					@endif
                @endif	                
		
					<select class="" style="    margin-left: auto !important;" onchange="return chk_lang()" id="lang">
						<option value="en" @if (App::getLocale()=='en') {{'selected'}} @endif>English</option>
						<option value="ar" @if (App::getLocale()=='ar') {{'selected'}} @endif>Arabic</option>
						
					</select>			
                  <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login',app()->getLocale()) }}">{{ __('messages.Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register',app()->getLocale()) }}">{{ __('messages.Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout',app()->getLocale()) }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('messages.Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout',app()->getLocale()) }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

	<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.css')}}" />
	<script src="{{ asset('js/bootstrap-datepicker.js') }}" ></script>
	<script>
		// initialize input widgets first


		$('.date , .date2').datepicker({
			'format': 'yyyy-mm-dd',
			'autoclose': true
		});

	</script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
  
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
	<script>
		$(document).ready( function () {
			var lang = document.getElementById('lang').value.trim();	
			if(lang == 'ar'){
				$('#example,#example2,#example3').DataTable({
					"language"			: {
					"sProcessing"		:   "جارٍ التحميل...",
					"sLengthMenu"		:   "أظهر _MENU_ مدخلات",
					"sZeroRecords"		:  "لم يعثر على أية سجلات",
					"sInfo"				:   "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
					"sInfoEmpty"		:  "يعرض 0 إلى 0 من أصل 0 سجل",
					"sInfoFiltered"		: 	"(منتقاة من مجموع _MAX_ مُدخل)",
					"sInfoPostFix"		:  "",
					"Type to filter..."	:	"ابحث...",

					"sSearch":       "ابحث:",
					"sUrl":          "",
					"oPaginate": {
						"sFirst":    "الأول",
						"sPrevious": "السابق",
						"sNext":     "التالي",
						"sLast":     "الأخير"
					}
					},					
					
				});
			}else{
				$('#example,#example2,#example3').DataTable();
			}				
				

		} );
	</script>
	<script>
		function chk_lang(){
		    var lang = document.getElementById('lang').value.trim();
				$.ajax({
                    url: "/changelangouage",
					type: "get", // call the function in index controler 
					data: {
						lang:lang,
					},
					success: function(result)
					{
						var arr = [ "ar", "en" ];
						var href = window.location.href;

						if(href.search("/ar/") > -1 ){
							var res = href.replace("/ar/", '/'+lang+'/');
						}
						else if(href.search("/en/") > -1){
							var res = href.replace("/en/", '/'+lang+'/');
							
						}
						window.location.href=res;
						return true;
					}
				   });			
			
		}
	</script>
</body>
</html>
