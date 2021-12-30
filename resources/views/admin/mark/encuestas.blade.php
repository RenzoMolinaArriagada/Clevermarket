@extends('admin.principal')

@section('content')
<h2><span class="box-icon"><i class="fas fa-bullhorn"></i></span> Creación de encuestas para la plataforma.</h2>
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
			<a class="btn btn-xs btn-primary m-1" href="{{route('mark.formCreateEncuesta')}}">Crear nueva encuesta</a>
		</div>
	</div>
	<div class="row">
		<h4>Encuestas anteriores</h4>
		<table class="table">
			<thead>
				<tr>
					<th>#</th>
					<th>Nombre</th>
					<th>Descripción</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
				@foreach($encuestas as $encuesta)
				<tr>
					<td>{{$loop->iteration}}</td>
					<td>{{$encuesta->nombre}}</td>
					<td><span class="desCorta">{{$encuesta->descripcion}}</span></td>		
					<td>
						<a class="btn btn-xs btn-primary mb-1" href="{{route('admin.formEditProducto',['clase' => $clase, 'producto' => $encuesta])}}">Editar</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		{{ $encuestas->links() }}
	</div>
</div>
@endsection
@section('ajax')
@endsection