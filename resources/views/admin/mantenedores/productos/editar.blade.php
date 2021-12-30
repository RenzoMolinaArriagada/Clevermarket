@extends('admin.principal')

@section('content')
<h2><span class="box-icon"><i class="fas fa-newspaper" aria-hidden="true"></i></span> Mantenedor de {{$clase->nombre}}</h2>
<h4>Editando {{$clase->nombre}} de nombre <b>{{$producto->nombre}}</b></h4>
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
	<form action="{{route('admin.updateProducto',['clase' => $clase, 'producto' => $producto])}}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
		@csrf @method('PATCH')
		<x-admin.datos-comerciales
			:producto="$producto"
			:marcas="$marcas"
		/>
		<x-admin.form-buttons
			:ruta="route('admin.manProductos',$clase)"
		/>		
	</form>
</div>
@endsection