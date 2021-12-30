@extends('admin.principal')

@section('content')
<h2><span class="box-icon"><i class="fas fa-newspaper" aria-hidden="true"></i></span> Mantenedor de cargas Masivas</h2>
<h4>Revision de carga masiva</h4>
<p>Por favor, revise que los productos se hayan cargado de manera correcta y recuerde que la imagen debe ser cargada con posterioridad</p>
<p>Los productos se guardaran con estado inactivo para que pueda cargar la imagen manualmente y luego activarlos.</p>
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
	<div class="row">
		<table class="table">
			<thead>
				<tr>
					<th>#</th>
					<th>SKU</th>
					<th>Clase</th>
					<th>Nombre</th>
					<th>N/Fabricante</th>
					<th>Descripción</th>
					<th>Marca</th>
					<th>Precio</th>
					<th>Cantidad</th>
				</tr>
			</thead>
			<tbody>
				@foreach($productos as $producto)
				<tr>
					<td>{{$loop->iteration}}</td>
					<td>{{$producto->sku}}</td>
					<td>{{$producto->clase->nombre}}</td>
					<td>{{$producto->nombre}}</td>
					<td>{{$producto->nombre_fabricante}}</td>
					<td><span class="desCorta">{{$producto->descripcion}}</span></td>
					<td>{{$producto->marca->nombre}}</td>
					<td>{{$producto->precio}}</td>
					<td>{{$producto->cantidad}}</td>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
<form action="{{route('admin.createProductoMasivo')}}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
	@csrf
	<div class="form-group row mt-1">
		<div class="col">
			<input type="submit" class="btn btn-xs btn-primary" title="" value="Cargar Productos Planilla"/>
		</div>
	</div>
</form>
@endsection
@section('ajax')
@endsection