@extends('admin.principal')

@section('content')
<h2><span class="box-icon"><i class="fas fa-medal"></i></span> Codigos de descuento para clientes</h2>
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
			<a class="btn btn-xs btn-primary m-1" href="{{route('fid.formCreateCodigoDescuento')}}">Crear nuevo codigo</a>
		</div>
	</div>
	<div class="row">
		<h4>Codigos de página activos</h4>
		<table class="table">
			<thead>
				<tr>
					<th>#</th>
					<th>Nombre</th>
					<th>Descuento</th>
					<th>Usos restantes</th>
					<th>Tipo</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
				@foreach($codigos as $codigo)
				<tr>
					<td>{{$loop->iteration}}</td>
					<td>{{$codigo->nombre}}</td>
					<td>{{$codigo->descuento}}</td>
					<td>@if($codigo->usos_restantes == -1) Sin limite @else {{$codigo->usos_restantes}} @endif</td>
					<td>@if($codigo->tipo == 1) Publico @else Privado @endif</td>
					<td>
						<a class="btn btn-xs btn-primary mb-1" href="{{route('fid.formEditCodigoDescuento',$codigo)}}">Editar</a>
						<button id="{{$codigo->id}}" name="silla" class="btn btn-xs btn-primary mb-1 btn-silla {{$codigo->activo == 1 ? 'btn-success' : 'btn-danger'}}">{{$codigo->activo == 1 ? 'Activo' : 'Inactivo'}}</button>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection
@section('ajax')
@endsection