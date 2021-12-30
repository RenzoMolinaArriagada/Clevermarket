@extends('admin.principal')

@section('content')
<h2><span class="box-icon"><i class="fas fa-newspaper" aria-hidden="true"></i></span> Mantenedor de {{$clase->nombre}}</h2>
<div class="col align-self-center">
	@if(session('exito'))
	    <div class="alert alert-success text-md-center" role="alert">
			{{session('exito')}}
		</div>
	@endif
</div>
<div class="container-fluid mt-3">
	<div class="row m-3">
		<div class="col-md-6">
			<a class="btn btn-xs btn-primary m-1" href="{{route('admin.formCreateProducto',$clase)}}">Crear nuev@ {{$clase->nombre}}</a>
		</div>
	</div>
	<div class="row">
		<h4>{{$clase->nombre}}</h4>
		<table class="table">
			<thead>
				<tr>
					<th>#</th>
					<th>SKU</th>
					<th>Imagen</th>
					<th>Nombre</th>
					<th>N/Fabricante</th>
					<th>Descripción</th>
					<th>Marca</th>
					<th>Precio</th>
					<th>Cantidad</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
				@foreach($productos as $producto)
				<tr>
					<td>{{$loop->iteration}}</td>
					<td>{{$producto->sku}}</td>
					<td><img src="{{asset($producto->imagen_principal)}}" class="table-img-fg "></td>
					<td>{{$producto->nombre}}</td>
					<td>{{$producto->nombre_fabricante}}</td>
					<td><span class="desCorta">{{$producto->descripcion}}</span></td>
					<td>{{$producto->marca->nombre}}</td>
					<td>{{$producto->precio}}</td>
					<td>
						<button idcant="{{$producto->id}}" class="mr-auto btn-suma"><i class="fas fa-plus-circle"></i></button>
						<label>{{$producto->cantidad}}</label>
						<button idcant="{{$producto->id}}" class="ml-auto btn-resta"><i class="fas fa-minus-circle"></i></button>
					</td>			
					<td>
						<a class="btn btn-xs btn-primary mb-1" href="{{route('admin.formEditProducto',['clase' => $clase, 'producto' => $producto])}}">Editar</a>
						<button id="{{$producto->id}}" name="silla" class="btn btn-xs btn-primary mb-1 btn-silla {{$producto->activo == 1 ? 'btn-success' : 'btn-danger'}}">{{$producto->activo == 1 ? 'Activo' : 'Inactivo'}}</button>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		{{ $productos->links() }}
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

    $('#content').on('click','.btn-silla',function(){
		event.preventDefault();
		var id = $(this).attr('id');
		var btnClickeado = $(this);
	    $.ajax({
	    	type:'PATCH',
	    	url:"{{ route('admin.activadorProductos',$clase) }}",
	    	data:{id:id,_method:'PATCH'},
	    	success:function(data){	
				accion = data.success;
		    	if(accion === "activado"){
		    		btnClickeado.removeClass('btn-danger');
		    		btnClickeado.addClass('btn-success');
		    		btnClickeado.html('Activo');
		    	}
		    	if (accion === "desactivado") {
		    		btnClickeado.removeClass('btn-success');
		    		btnClickeado.addClass('btn-danger');
		    		btnClickeado.html('Inactivo');
		    	}
	    	},
	    	error:function(data){
	    		alert("Ha ocurrido un error inesperado");
	    	}
	    });
	})

	$('#content').on('click','.btn-suma',function(){
		event.preventDefault();
		var id = $(this).attr('idcant');
		var btnClickeado = $(this);
	    $.ajax({
	    	type:'PATCH',
	    	url:"{{ route('admin.cantidadProductos',$clase) }}",
	    	data:{id:id,tipo:'suma',_method:'PATCH'},
	    	success:function(data){	
	    		accion = data.success;
	    		if(accion === "excede"){
	    			alert("No puedes exceder la cantidad maxima");
	    		}
	    		else{
	    			location.reload();
	    		}
	    	},
	    	error:function(data){
	    		alert("Ha ocurrido un error inesperado");
	    	}
	    });
	})


	$('#content').on('click','.btn-resta',function(){
		event.preventDefault();
		var id = $(this).attr('idcant');
		var btnClickeado = $(this);
	    $.ajax({
	    	type:'PATCH',
	    	url:"{{ route('admin.cantidadProductos',$clase) }}",
	    	data:{id:id,tipo:'resta',_method:'PATCH'},
	    	success:function(data){	
	    		accion = data.success;
	    		if(accion === "excede"){
	    			alert("No puedes exceder la cantidad minima");
	    		}
	    		else{
	    			location.reload();
	    		}
	    	},
	    	error:function(data){
	    		alert("Ha ocurrido un error inesperado");
	    	}
	    });
	})
</script>
@endsection