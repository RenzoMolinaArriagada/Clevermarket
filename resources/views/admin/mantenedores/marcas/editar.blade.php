@extends('admin.principal')

@section('content')
<h2><span class="box-icon"><i class="fas fa-newspaper" aria-hidden="true"></i></span> Mantenedor de Marcas</h2>
<h4>Editando la marca <b>{{$marca->nombre}}</b></h4>
<br>
<h4>Procure revisar los datos a modificar antes de presionar el boton guardar.</h4>
<div class="col align-self-center">
	@error('iguales')
	    <div class="alert alert-danger text-md-center" role="alert">
			{{$message}}
		</div>
	@endif
</div>
<div class="container-fluid mt-3">
	<form action="{{route('admin.updateMarca',$marca)}}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
		@csrf @method('PATCH')
		<x-admin.mantenedores.marcas
			:marca="$marca"
		/>
		<x-admin.form-buttons
			:ruta="route('admin.manMarcas')"
		/>		
	</form>
</div>
@endsection