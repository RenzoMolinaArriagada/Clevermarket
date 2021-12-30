@extends('admin.principal')

@section('content')
<h2><span class="box-icon"><i class="fas fa-newspaper" aria-hidden="true"></i></span> Mantenedor de Marcas</h2>
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
			<a class="btn btn-xs btn-primary m-1" href="{{route('admin.formCreateMarca')}}">Crear nueva Marca</a>
		</div>
	</div>
	<div class="row">
		<h4>Creadas en el sistema:</h4>
		<table class="table">
			<thead>
				<tr>
					<th>#</th>
					<th>Nombre</th>
					<th>Productos Asociados</th>
				</tr>
			</thead>
			<tbody>
				@foreach($marcas as $marca)
				<tr>
					<td>{{$loop->iteration}}</td>
					<td>{{$marca->nombre}}</td>
					<td>{{$marca->productosActivos()->count()}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
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
	    	url:"{{ route('admin.activadorProductos',$marca) }}",
	    	data:{id:id,_method:'PATCH'},
	    	success:function(data){	
				accion = data.success;
		    	if(accion === "activado"){
		    		btnClickeado.removeClass('btn-danger');
		    		btnClickeado.addClass('btn-success');
		    	}
		    	if (accion === "desactivado") {
		    		btnClickeado.removeClass('btn-success');
		    		btnClickeado.addClass('btn-danger');
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
	    	url:"{{ route('admin.cantidadProductos',$marca) }}",
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
	    	url:"{{ route('admin.cantidadProductos',$marca) }}",
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