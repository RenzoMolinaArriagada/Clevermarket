@extends('admin.principal')

@section('content')
<h2><span class="box-icon"><i class="fas fa-newspaper" aria-hidden="true"></i></span> Mantenedor de Usuarios</h2>
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
			<a class="btn btn-xs btn-primary m-1" href="{{route('admin.formCreateUsuario')}}">Crear nuevo Usuario</a>
		</div>
	</div>
	<div class="row">
		<h4>Creados en el sistema:</h4>
		<table class="table">
			<thead>
				<tr>
					<th>#</th>
					<th>Nombre</th>
					<th>Email</th>
					<th>Tipo de Perfil</th>
					<th>Editar</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach($usuarios as $usuario)
				<tr>
					<td>{{$loop->iteration}}</td>
					<td>{{$usuario->name}}</td>
					<td>{{$usuario->email}}</td>
					<td>{{$usuario->tienePerfil->nombre}}</td>
					<td><a class="btn btn-xs btn-primary mb-1" href="{{route('admin.formEditUsuario',$usuario)}}">Editar</a></td>
					<td><button id="{{$usuario->id}}" class="btn btn-xs btn-primary mb-1 btn-activador {{$usuario->activo == 1 ? 'btn-success' : 'btn-danger'}}">{{$usuario->activo == 1 ? 'Activo' : 'Inactivo'}}</button></td>	
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

    $('#content').on('click','.btn-activador',function(){
		event.preventDefault();
		var btnClickeado = $(this);
		var id = btnClickeado.attr('id');
	    $.ajax({
	    	type:'PATCH',
	    	url:"{{ route('admin.activadorUsuarios') }}",
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
	});
</script>
@endsection