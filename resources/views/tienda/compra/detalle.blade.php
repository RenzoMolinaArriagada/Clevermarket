@extends('layouts.main')
@section('contenido')
<div class="container mb-auto" id="content">
	<div class="d-flex row justify-content-center">
		<div class="col col-md-8">
			<h4>Detalle de la compra</h4>
			@foreach($carroCompleto as $producto)
			<div class="row">
					<div class="">
						<div class="row border menu-border-fg rounded-3">
							<div class="col-3 col-md-2 d-flex flex-wrap align-items-center text-center">
								<img class="img-prodcarro-fg img-fluid align-middle" src="{{asset($producto->producto->imagen_principal)}}">
							</div>
							<div class="col-7 col-md-7">
								<div class="row">
									<div class="col-12">
										<label for="nomprod" class="label label-prod-fg">Nombre</label>
									</div>
									<div class="col-12 ml-3">
										<p id="nomprod">{{$producto->producto->nombre}}</p>
									</div>	
								</div>
								<div class="row">
									<div class="col-12">
										<label for="marcaprod" class="label label-prod-fg">Marca</label>
									</div>
									<div class="col-12 ml-3">
										<p id="marcaprod">{{$producto->producto->marca->nombre}}</p>
									</div>
								</div>
							</div>
							<div class="col-2 col-md-3">
								<div class="row">
									<div class="col-12">
										<label for="marcaprod" class="label label-prod-fg">Cantidad</label>
									</div>
									<div class="col-12 ml-3">
										<label cantidad="{{$producto->cantidad}}">{{$producto->cantidad}}</label>
									</div>
								</div>
								<div class="row">
									<div class="col-12">
										<label for="marcaprod" class="label label-prod-fg">Precio</label>
									</div>
									<div class="col-12 ml-3">
										<label>${{$producto->cantidad * $producto->producto->precio}}</label>
									</div>									
								</div>
								@if($venta->codigo_descuento_id != null)
								<div class="row">
									<div class="col-12">
										<label for="marcaprod" class="label label-prod-fg">Precio con Descuento</label>
									</div>
									<div class="col-12 ml-3">
										<label>${{ceil($producto->cantidad * $producto->producto->precio * (1-$venta->codigoDescuento->descuento))}}</label>
									</div>									
								</div>
								@endif
							</div>
						</div>
					</div>		
			</div>
		@endforeach
		<div class="row">
			<div class="col-10 col-md-9">
				<h4>Total</h4>
			</div>
			<div class="col-2 col-md-3">
				<label class="label label-prod-fg">${{$venta->precio_total}}</label>
				@if($venta->codigo_descuento_id != null)<label class="label label-prod-fg">${{ceil($venta->precio_total * (1-$venta->codigoDescuento->descuento))}}</label>@endif
			</div>	
		</div>
		<div class="d-flex flex-row-reverse">
			<a class="flex-fill btn btn-precio-fg" href="{{route('home')}}">Volver a la pagina principal</a>
		</div>
		</div>
	</div>
</div>
@endsection