<!DOCTYPE html>
<html>
<head>
	<title>Confirmacion de la compra</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
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
				<label class="label label-prod-fg">${{$precio_total}}</label>
			</div>	
		</div>
		</div>
	</div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>