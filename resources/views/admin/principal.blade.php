<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{asset('/images/logo.png')}}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link href="{{ asset('css/style_template.css') }}" rel="stylesheet">
    <!--Wysiwyg TinyMCE-->
    <script src="https://cdn.tiny.cloud/1/ura0ooblhkwf1uu9x9prhmwpn3ny47sw6xgj29vkc6vlaf83/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>tinymce.init({
    selector:'#desc',
    plugins: [
      'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
      'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
      'table emoticons template paste help'
    ],
    toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
      'bullist numlist outdent indent | link image | print preview media fullpage | ' +
      'forecolor backcolor emoticons | help'
    });
    </script>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
		<script src="{{ asset('js/app.js') }}" defer></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
</head>
<body>
<div id=main>
	<div class="wrapper">
		<nav id="sidebar">
			<div class="sidebar-header text-center">
			    <li class="nav-header" style="list-style-type: none;">
			        <div class="initialinfo-user">
			            <div class="initialinfo-user-img">
			                <a href="{{route('home')}}" title=""><img src="{{asset('/images/logo.png')}}" class="img-responsive img-circle"></a>
			            </div>
			            <div class="initialinfo-user-name">
			                <h4>{{Auth::user()->name}}</h4>
			            </div>
			            <div class="initialinfo-user-job">
			                <h6>{{Auth::user()->tienePerfil->nombre}}</h6>
			            </div>
			        </div>
			    </li>
			</div>
			<ul class="list-unstyled components">
		        <li>
		            <a href="{{route('admin')}}">
		                <i class="fas fa-home"></i>
		                <span class="nav-label">Dashboard</span>
		            </a>
		        </li>
		        @if(Auth::user()->perfil == 2)
	        		<li class="{{ Route::is('admin.manVentas') ? 'active' : '' }}">
	        			<a href="{{route('admin.manVentas')}}">
	        				<i class="fas fa-handshake"></i>
	        				<span class="nav-label">Ventas</span>
	        			</a>
	        		</li>
        		@endif
		        <li class="list-content-menu">
            		<a href="#admProductos" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="admProductos" class="collapsed has-arrow">
                		<i class="fas fa-shopping-bag"></i>
                		<span class="nav-label">Productos</span>
            		</a>
            		<div class="collapse {{ Request::is('administracion/productos/*') ? 'show' : '' }}" id="admProductos">
	            		<ul class="list-unstyled nav-second-level">
							@foreach($clases as $clase)
								<li class="{{ Request::is('administracion/productos/'. $clase->nombre) ? 'active' : '' }}">
									<a href="{{route('admin.manProductos',$clase)}}">{{$clase->nombre}}</a>
								</li>
							@endforeach
		            	</ul>
            		</div>
        		</li>        		
        		<li class="list-content-menu">
            		<a href="#admMarketing" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="admMarketing" class="collapsed has-arrow">
            				<i class="fas fa-comments-dollar"></i>
                		<span class="nav-label">Marketing</span>
            		</a>
            		<div class="collapse {{ Request::is('administracion/marketing/*') ? 'show' : '' }}" id="admMarketing">
	            		<ul class="list-unstyled nav-second-level">
	            			<li class="{{ Route::is('admin.emailPublicidad') ? 'active' : '' }}">
											<a href="{{route('admin.emailPublicidad')}}">Mailing Publicidad</a>
										</li>
										{{-- <li class="{{ Route::is('admin.emailEncuestas') ? 'active' : '' }}">
											<a href="{{route('admin.emailEncuestas')}}">Encuestas</a>
										</li> --}}
		            	</ul>
            		</div>
        		</li>
        		<li class="list-content-menu">
            		<a href="#admFidelizacion" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="admFidelizacion" class="collapsed has-arrow">
                		<i class="fas fa-medal"></i>
                		<span class="nav-label">Fidelizacion</span>
            		</a>
            		<div class="collapse {{ Request::is('administracion/fidelizacion/*') ? 'show' : '' }}" id="admFidelizacion">
	            		<ul class="list-unstyled nav-second-level">
	            			<li class="{{ Route::is('fid.manCodigosDescuento') ? 'active' : '' }}">
											<a href="{{route('fid.manCodigosDescuento')}}">Codigos de Descuento</a>
										</li>
		            	</ul>
            		</div>
        		</li>
        		<li class="list-content-menu">
            		<a href="#admMantenedores" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="admMantenedores" class="collapsed has-arrow">
                		<i class="fas fa-edit"></i>
                		<span class="nav-label">Mantenedores de Sistema</span>
            		</a>
            		<div class="collapse {{ Request::is('administracion/mantenedores/*') ? 'show' : '' }}" id="admMantenedores">
	            		<ul class="list-unstyled nav-second-level">
	            			<li class="{{ Route::is('admin.manUsuarios') ? 'active' : '' }}">
								<a href="{{route('admin.manUsuarios')}}">Usuarios</a>
							</li>
							<li class="{{ Route::is('admin.manClases') ? 'active' : '' }}">
								<a href="{{route('admin.manClases')}}">Clases</a>
							</li>
							<li class="{{ Route::is('admin.manMarcas') ? 'active' : '' }}">
								<a href="{{route('admin.manMarcas')}}">Marcas</a>
							</li>
							<li class="{{ Route::is('admin.manAudits') ? 'active' : '' }}">
								<a href="{{route('admin.manAudits')}}">Auditoria</a>
							</li>
		            	</ul>
            		</div>
        		</li>
		        @if(Auth::user()->perfil == 1)
        		<li class="{{ Route::is('admin.manVentas') ? 'active' : '' }}">
        			<a href="{{route('admin.manVentas')}}">
        				<i class="fas fa-handshake"></i>
        				<span class="nav-label">Ventas</span>
        			</a>
        		</li>
        		<li class="{{ Route::is('admin.manPersonalizacion') ? 'active' : '' }}">
		            <a href="{{route('admin.manPersonalizacion')}}">
		                <i class="fas fa-edit"></i>
		                <span class="nav-label">Personalizar Sitio</span>
		            </a>
		        </li>
		        <li class="{{ Route::is('admin.panelIntegraciones') ? 'active' : '' }}">
		            <a href="{{route('admin.panelIntegraciones')}}">
		                <i class="fas fa-shopping-cart"></i>
		                <span class="nav-label">Integraciones</span>
		            </a>
		        </li>
		        @endif
	    	</ul>
		</nav>
		<div id="content">
			<div class="row navbar navbar-expand-md">
	                <div class="container-fluid">
	                    <div class="row">
	                        <div class="col-md-6">
	                            <button type="button" id="sidebarCollapse" class="btn btn-primary navbar-btn">
	                                <i class="fa fa-bars"></i>
	                            </button>
	                        </div>
	                    </div>
	                </div>
	        </div>
	        	@if(Route::is('admin'))
		        	<div class="row">
						<div class="d-flex col">
							<div class="align-items-center text-center">
								<h2><i class="fas fa-exclamation-triangle"></i>Dashboard en construccion<i class="fas fa-exclamation-triangle"></i></h2>
							</div>
						</div>
					</div>
	        	@endif
				@yield('content')			
		</div>
	</div>

</div>
</body>
@yield('ajax')
</html>