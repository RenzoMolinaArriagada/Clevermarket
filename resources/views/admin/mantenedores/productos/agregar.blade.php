@extends('admin.principal')

@section('content')
<h2><span class="box-icon"><i class="fas fa-newspaper" aria-hidden="true"></i></span> Mantenedor de {{$clase->nombre}}</h2>
<h4>Agregando un@ {{$clase->nombre}}</b></h4>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="container-fluid mt-3">
	<form action="{{route('admin.createProducto',$clase)}}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
		@csrf
		<x-admin.datos-comerciales
			:producto="''"
			:marcas="$marcas"
		/>
		<x-admin.form-buttons
			:ruta="route('admin.manProductos',$clase)"
		/>	
	</form>
</div>
@endsection