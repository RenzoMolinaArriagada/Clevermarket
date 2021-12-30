@isset($personalizacion)
<div class="container-fluid header-forcegamer" style="background-image: url('{{$personalizacion->img_banner}}')">
@else
<div class="container-fluid header-forcegamer" style="background-image: url('{{asset('images/default/universe.jpg')}}')">
@endisset
	<div class="row">
	    <div class="col mt-auto mb-auto">
	      {{--<a class="nav-item nav-link" href="https://www.instagram.com/fg_forcegamer/"><i class="fab fa-instagram fa-3x nav-rs"></i></a>--}}
	    </div>
	    <div class="col text-center mt-auto mb-auto">
	    	@isset($personalizacion)
	    	<a href="{{route('home')}}"><img class="img-fluid mx-auto align-middle d-block logo-fg" src="{{$personalizacion->img_logo}}"></a>
	    	@else
	    	<a href="{{route('home')}}"><img class="img-fluid mx-auto align-middle d-block logo-fg" src="{{asset('images/default/logo_default.png')}}"></a>
	    	@endisset
	    </div>
	    <div class="col mt-auto mb-auto d-flex flex-row-reverse">
	    	@guest
	    	<a class="nav-link-fg ml-2" href="{{route('register')}}"  title="">{{ __('Register')}}</a>
	    	<span class="hiddeable"> | </span>
	    	<a class="nav-link-fg mr-2" href="{{route('login')}}"  title="">{{ __('Login')}}</a>
	    	@endguest
	    	@auth
              <form method="POST" action="{{ route('logout') }}" class="ml-2">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Logout') }}
                    </x-dropdown-link>
                </form>
                <span class="hiddeable"> | </span>
                <a class="nav-link-fg mr-2 ml-2" href="{{route('compra.verCarro')}}"><i class="fas fa-shopping-cart"></i>({{Auth::user()->contarCarro()}})</a>
                <span class="hiddeable"> | </span>
                @if(Auth::user()->perfil == 1 || Auth::user()->perfil == 2)
                	<a href="{{route('admin')}}" class="mr-2" style="color: white">Hola {{Auth::user()->name}}</a>
                @else
                	<a href="{{route('user.perfil',Auth::user())}}" class="mr-2" style="color: white">Hola {{Auth::user()->name}}</a>
                @endif
	    	@endauth
	    </div>		
	</div>

</div>
<div class="d-flex justify-content-between align-items-center nav-forcegamer text-center">
		@foreach($clases as $clase)
		<div class="col">
			<a class="nav-link-fg" href="{{route('productos.mostrar',$clase)}}" title="">{{$clase->nombre}}</a>
		</div>
		@endforeach
</div>


