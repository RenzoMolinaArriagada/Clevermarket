@extends('layouts.main')
@section('contenido')
<div class="container mb-auto" id="content">
	@if(!is_null($carroCompleto))
	<div class="row">
		<div class="col-md-8 col-8">
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
								<div class="col-2 col-md-3 d-flex flex-wrap align-items-center text-center">
									<div class="row">				
										<button idcant="{{$producto->producto_id}}" operacion="suma" class="mr-auto btn-suma-resta"><i class="fas fa-plus-circle"></i></button>
										<label cantidad="{{$producto->cantidad}}">{{$producto->cantidad}}</label>
										<button idcant="{{$producto->producto_id}}" operacion="resta" class="ml-auto btn-suma-resta"><i class="fas fa-minus-circle"></i></button>
									</div>
									<div class="row">
										<label>${{$producto->cantidad * $producto->producto->precio}}</label>
									</div>
								</div>
							</div>
						</div>		
				</div>
			@endforeach

		</div>
		<div class="col">
			<div class="d-flex flex-fill justify-content-center align-items-center">
				<form action="{{route('compra.verDatos')}}" method="post" accept-charset="utf-8">
					@csrf
					<button type="submit" class="flex-fill btn btn-precio-fg" title="">Siguiente Paso</button>
				</form>
			</div>
		</div>
	</div>
	@else
		<div class="row">
			<div class="">
				<div class="row border menu-border-fg rounded-3">
					<h1>No hay objetos en el carro</h1>
				</div>
			</div>
		</div>
	@endif
	<div class="row" id="contenidoRecomendados">
		<h4>Recomendaciones para ti</h4>
		<x-tienda.recomendados :recomendaciones="$recomendaciones"/>
	</div>
</div>
@endsection
@section('ajax')
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#content').on('click','.btn-suma-resta',function(){
		event.preventDefault();
		var btnClickeado = $(this);
		var id = $(this).attr('idcant');
		var operacion = $(this).attr('operacion');
	    $.ajax({
	    	type:'PATCH',
	    	url:"{{ route('carro.modificarCantidad') }}",
	    	data:{id:id,operacion:operacion,_method:'PATCH'},
	    	success:function(data){	
	    		accion = data.success;
	    		if(accion === "excedemaximo"){
	    			alert("No puedes exceder la cantidad máxima");
	    		}
	    		if(accion === "excedeminimo"){
	    			alert("No puedes exceder la cantidad mínima");
	    		}
	    		else{
	    			location.reload();
	    			console.log(accion);
	    		}
	    	},
	    	error:function(data){
	    		accion = data.error;
	    		alert("Ha ocurrido un error inesperado " + accion);
	    	}
	    });
	});

    $('#contenidoRecomendados').on('click','#btn-agregarcarro-fg',function(){
			event.preventDefault();
			var idProducto = {{$producto->id ?? ''}};
			@if(Auth::check())
				var idUser = {{Auth::user()->id}};
			@endif
			var btnClickeado = $(this);
		    $.ajax({
		    	type:'POST',
		    	url:"{{ route('carro.agregar') }}",
		    	data:{idProducto:idProducto,idUser:idUser,_method:'POST'},
		    	success:function(data){
		    		location.reload();
		    		estado = data.success;
		    		console.log(estado);
		    	},
		    	error:function(data){
		    		estado = data.error;
		    		console.log(estado);
		    		alert("Algo fallo en el proceso, por favor contactenos para solucionar su problema a la brevedad");
		    	}
		    });
		});
</script>
@endsection