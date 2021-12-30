@extends('layouts.main')
@section('contenido')
<div class="container mb-auto" id="content">
	<div class="row">
			<div class="col-6">
				<div class="row">
					<div class="col-12">
						<label for="nomprod" class="label label-prod-fg">Nombre</label>
					</div>
					<div class="col-12 ml-3">
						<p id="nomprod">{{$usuario->name}}</p>
					</div>	
				</div>
				<div class="row">
					<div class="col-12">
						<label for="marcaprod" class="label label-prod-fg">Email</label>
					</div>
					<div class="col-12 ml-3">
						<p id="marcaprod">{{$usuario->email}}</p>
					</div>
				</div>
			</div>
	</div>
	@if(Auth::user()->id == $usuario->id)
	<h4><i class="fas fa-boxes"></i> Mis Compras</h4>
	<div class="row overflow-auto">
		<div class="col">
			<div class="row">
				@if($compras != NULL)
				<table class="table">
					<thead>
						<tr>
							<th>#</th>
							<th>Valor total</th>
							<th>¿Descuento?</th>
							<th>N° de articulos</th>
							<th>Direccion</th>
							<th>Fecha Compra</th>
							<th>Estado</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
							@foreach($compras as $compra)
								<tr>
									<td>{{$loop->iteration}}</td>
									@if($compra->codigo_descuento_id != null)
									<td>${{ceil($compra->precio_total * (1-$compra->codigoDescuento->descuento))}}</td>				
									<td>{{$compra->codigoDescuento->descuento * 100}}%</td>
									@else
									<td>${{$compra->precio_total}}</td>
									<td>No aplica</td>
									@endif
									<td>{{$compra->cantidad_articulos}}</td>
									<td>{{$compra->calle . ' '.$compra->numeracion .', ' . $compra->comuna->comuna . '. ' . $compra->comuna->region->region}}</td>
									<td>{{$compra->created_at}}</td>
									<td>
										@switch($compra->estado)
											@case(1)
											Pendiente de envío
												@break
											@case(2)
											En despacho
												@break
											@case(3)
											Recibida
												@break
										@endswitch
									</td>
									<td>
										<div class="row">
											<div class="col">
												<button type="button" data-bs-toggle="collapse" data-bs-target="#det{{$compra->id}}" aria-expanded="false" aria-controls="det{{$compra->id}}" class="btn btn-detalle btn-precio-fg">Detalle</button>
											</div>
											@if($compra->estado == 2)
											<div class="col">
												<form action="{{route('venta.setRecibido',$usuario)}}" method="POST" accept-charset="utf-8">
													@csrf
													<input type="hidden" name="venta" value="{{$compra->id}}">
													<button class="btn btn-detalle btn-precio-fg" type="submit">Recibido</button>
												</form>	
											</div>										
											@endif
										</div>	
									</td>
								</tr>
								<tr class="collapse" id="det{{$compra->id}}">
									<td colspan="7">
										<div class="collapse" id="det{{$compra->id}}">
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
													@foreach($compra->productos as $producto)
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
					<h5>No has realizado compras en nuestra pagina web.</h5>
				@endif
			</div>
		</div>
	</div>
	@endif
	<div class="row">
		<div class="d-flex col">
			<div class="align-items-center text-center">
				<h2><i class="fas fa-exclamation-triangle"></i>Sitio en construccion<i class="fas fa-exclamation-triangle"></i></h2>
			</div>
		</div>
		
	</div>
</div>
@endsection