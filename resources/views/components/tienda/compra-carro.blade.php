@if($producto->cantidad > 0)
	<div class="col-6">
		<a href="" class="btn btn-precio-fg w-100">Comprar</a>
	</div>
	<div class="col-6">
		@if(Auth::user())
			<form method="POST" accept-charset="utf-8">
			    @csrf
				<button type="submit" id="btn-agregarcarro-fg" class="btn btn-precio-fg w-100">Agregar al carro</button>
			</form>
		@else
			<!-- Button trigger modal -->
			<button type="button" class="btn btn-precio-fg w-100" data-bs-toggle="modal" data-bs-target="#exampleModal">
			  Agregar al carro
			</button>

			<!-- Modal -->
			<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog modal-dialog-centered">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLabel">Debes Iniciar sesión...</h5>
			        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			      </div>
			      <div class="modal-body">
			      	<form action="{{ route('login') }}" method="POST" accept-charset="utf-8">
			            @csrf
			            <div class="container">
			            	<div class="row">
			            		<p>Si deseas comprar varias cosas al mismo tiempo, debes tener un usuario creado en nuestra página, asi te podemos ayudar a mantener un registro de tus compras.</p>
			            	</div>
				            <!-- Email Address -->
				            <div class="row mt-3">
				                <x-label for="email" :value="__('Email')" />

				                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
				            </div>

				            <!-- Password -->
				            <div class="row mt-3">
				                <x-label for="password" :value="__('Password')" />

				                <x-input id="password" class="block mt-1 w-full"
				                                type="password"
				                                name="password"
				                                required autocomplete="current-password" />
				            </div>
				            <div class="row mt-3">
				            	<button id="btn-iniciarsesion-modal-fg" type="submit" class="btn btn-precio-fg">Iniciar Sesión</button>
				            </div>
							<div class="row mt-3">
				            	<p>...o registrate <a href="{{route('register')}}">aquí</a></p>
				            </div>
			            </div>	
			      	</form>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
			      </div>
			    </div>
			  </div>
			</div>
		@endif
	</div>
@else
	<div class="col-12">
		<a disabled class="btn btn-precio-fg w-100">Notificarme en cuanto haya stock</a>
	</div>
@endif