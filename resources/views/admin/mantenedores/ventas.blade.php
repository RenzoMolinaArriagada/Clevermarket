@extends('admin.principal')

@section('content')
<h2><span class="box-icon"><i class="fas fa-handshake"></i></span> Ventas</h2>
<div class="col align-self-center">
	@if(session('exito'))
	    <div class="alert alert-success text-md-center" role="alert">
			{{session('exito')}}
		</div>
	@endif
</div>
<div class="container-fluid mt-3">
	<div class="row overflow-auto">
		<div class="col">
			<h4><span class="box-icon"><i class="fas fa-boxes"></i></span> Pendientes</h4>
			<div class="row">
				<table class="table">
					<thead>
						<tr>
							<th>#</th>
							<th>Comprador</th>
							<th>Valor total</th>
							<th>N° articulos</th>
							<th>Direccion</th>
							<th>Fecha Compra</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@if($ventasPendientes != NULL)
							@foreach($ventasPendientes as $venta)
								<tr>
									<td>{{$loop->iteration}}</td>
									<td>{{$venta->usuario->name}}</td>
									<td>${{$venta->precio_total}}</td>
									<td>{{$venta->cantidad_articulos}}</td>
									<td>{{$venta->calle . ' '.$venta->numeracion .', ' . $venta->comuna->comuna . '. ' . $venta->comuna->region->region}}</td>
									<td>{{$venta->created_at}}</td>
									<td>
										<button type="button" data-bs-toggle="collapse" data-bs-target="#pend{{$venta->id}}" aria-expanded="false" aria-controls="pend{{$venta->id}}" class="btn btn-primary btn-detalle">Detalle</button>
										<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-venta="{{$venta->id}}">Despachar</button>
									</td>
									
								</tr>
								<tr class="collapse" id="pend{{$venta->id}}">
									<td colspan="7">
										<div class="collapse" id="pend{{$venta->id}}">
											<table class="table border-3">
												<thead>
													<tr>
														<th>SKU</th>
														<th>Nombre</th>
														<th>N° articulos</th>
														<th>Valor total</th>
													</tr>
												</thead>
												<tbody>
													@foreach($venta->productos as $producto)
													<tr>
														<td>{{$producto->sku}}</td>
														<td>{{$producto->nombre}}</td>
														<td>{{$producto->detalle->cantidad_articulos}}</td>
														<td>${{$producto->detalle->precio_total}}</td>
													</tr>
													@endforeach
												</tbody>
											</table>
										</div>
									</td>
								</tr>
							@endforeach
						@else
						<h5>No hay ventas pendientes de envío o revisión.</h5>
						@endif
					</tbody>
				</table>
			</div>
		</div>
		<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		 	<div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLabel">Metodo de despacho</h5>
			        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
			      </div>
			      <div class="modal-body">
			      	<div class="row justify-content-center">
			      		@foreach($couriers as $courier)
			      		<div class="col-4">
			      			<form action="{{route('venta.ventaDespachar')}}" method="POST" accept-charset="utf-8">
					        	@csrf
					        	<div class="mb-3">
					        	<input type="hidden" name="venta" id="venta">
					        	</div>
					           	<input type="hidden" name="courier" id="courier" value="{{$courier->id}}">
						        <button type="submit" class="btn btn-primary"><i class="fas fa-truck"></i><br>Despachar con {{$courier->nombre}}</button>				          
					        </form>
			      		</div>
				        
				        @endforeach
			      	</div>
					
			      </div>
			    </div>
			</div>
		</div>
	</div>
	<div class="row overflow-auto">
		<div class="col">
			<h4><i class="fas fa-truck"></i> En Despacho</h4>
			<div class="row">
				@if($ventasDespachadas != NULL)
				<table class="table">
					<thead>
						<tr>
							<th>#</th>
							<th>Comprador</th>
							<th>Valor total</th>
							<th>N° articulos</th>
							<th>Direccion</th>
							<th>Fecha Compra</th>
							<th>Courier</th>
							<th></th>
						</tr>
					</thead>
					<tbody>						
							@foreach($ventasDespachadas as $venta)
								<tr>
									<td>{{$loop->iteration}}</td>
									<td>{{$venta->usuario->name}}</td>
									<td>${{$venta->precio_total}}</td>
									<td>{{$venta->cantidad_articulos}}</td>
									<td>{{$venta->calle . ' '.$venta->numeracion .', ' . $venta->comuna->comuna . '. ' . $venta->comuna->region->region}}</td>
									<td>{{$venta->created_at}}</td>
									<td>{{$venta->getCourier()->nombre}}</td>
									<td>
										<button type="button" data-bs-toggle="collapse" data-bs-target="#desp{{$venta->id}}" aria-expanded="false" aria-controls="desp{{$venta->id}}" class="btn btn-primary btn-detalle">Detalle</button>
									</td>
									
								</tr>
								<tr class="collapse" id="desp{{$venta->id}}">
									<td colspan="7">
										<div class="collapse" id="desp{{$venta->id}}">
											<table class="table border-3">
												<thead>
													<tr>
														<th>SKU</th>
														<th>Nombre</th>
														<th>N° articulos</th>
														<th>Valor total</th>
													</tr>
												</thead>
												<tbody>
													@foreach($venta->productos as $producto)
													<tr>
														<td>{{$producto->sku}}</td>
														<td>{{$producto->nombre}}</td>
														<td>{{$producto->detalle->cantidad_articulos}}</td>
														<td>${{$producto->detalle->precio_total}}</td>
													</tr>
													@endforeach
												</tbody>
											</table>
										</div>
									</td>
								</tr>
							@endforeach		
					</tbody>
				</table>
				@else
				<h5>No hay ventas en despacho en este momento.</h5>
				@endif
			</div>
		</div>
	</div>
	<div class="row overflow-auto">
		<div class="col">
			<h4><i class="fas fa-check-circle"></i> Cerradas</h4>
			<div class="row">
				@if($ventasCerradas != NULL)
				<table class="table">
					<thead>
						<tr>
							<th>#</th>
							<th>Comprador</th>
							<th>Valor total</th>
							<th>N° articulos</th>
							<th>Direccion</th>
							<th>Fecha Compra</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
							@foreach($ventasCerradas as $venta)
								<tr>
									<td>{{$loop->iteration}}</td>
									<td>{{$venta->usuario->name}}</td>
									<td>${{$venta->precio_total}}</td>
									<td>{{$venta->cantidad_articulos}}</td>
									<td>{{$venta->calle . ' '.$venta->numeracion .', ' . $venta->comuna->comuna . '. ' . $venta->comuna->region->region}}</td>
									<td>{{$venta->created_at}}</td>
									<td>
										<button type="button" data-bs-toggle="collapse" data-bs-target="#cerr{{$venta->id}}" aria-expanded="false" aria-controls="cerr{{$venta->id}}" class="btn btn-primary btn-detalle">Detalle</button>
									</td>
									
								</tr>
								<tr class="collapse" id="cerr{{$venta->id}}">
									<td colspan="7">
										<div class="collapse" id="cerr{{$venta->id}}">
											<table class="table border-3">
												<thead>
													<tr>
														<th>SKU</th>
														<th>Nombre</th>
														<th>N° articulos</th>
														<th>Valor total</th>
													</tr>
												</thead>
												<tbody>
													@foreach($venta->productos as $producto)
													<tr>
														<td>{{$producto->sku}}</td>
														<td>{{$producto->nombre}}</td>
														<td>{{$producto->detalle->cantidad_articulos}}</td>
														<td>${{$producto->detalle->precio_total}}</td>
													</tr>
													@endforeach
												</tbody>
											</table>
										</div>
									</td>
								</tr>
							@endforeach
						
					</tbody>
				</table>
				@else
					<h5>No hay ventas en despacho en este momento.</h5>
				@endif
			</div>
		</div>
	</div>
</div>
@endsection
@section('ajax')
<script>
	var exampleModal = document.getElementById('exampleModal')
	exampleModal.addEventListener('show.bs.modal', function (event) {
	  // Button that triggered the modal
	  var button = event.relatedTarget
	  // Extract info from data-bs-* attributes
	  var venta_id = button.getAttribute('data-bs-venta')
	  // If necessary, you could initiate an AJAX request here
	  // and then do the updating in a callback.
	  //
	  // Update the modal's content.
	  var modalVentaInput = exampleModal.querySelector('.modal-body #venta')

	  modalVentaInput.value = venta_id
	})

</script>
@endsection