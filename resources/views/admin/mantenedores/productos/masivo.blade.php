@extends('admin.principal')

@section('content')
<h2><span class="box-icon"><i class="fas fa-newspaper" aria-hidden="true"></i></span> Mantenedor de cargas Masivas</h2>
<h4>Agregando productos de manera masiva</b></h4>
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
		<div class="form-group row mt-1">
			<div class="col">
				<a class="btn btn-xs btn-primary" href="{{asset('archivos/formato/carga_masiva.csv')}}" title="">Descargar Plantilla</a>
			</div>
		</div>
	<form action="{{route('admin.setProductoMasivo')}}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
		@csrf
		<div class="form-group row mt-1">
			<div class="col">
				<label for="csvCarga" class="label-prod-fg">Archivo CSV</label>
				<input id="csvCarga" type="file" name="csvCarga" class="form-control border-1 border-secondary p-2 @error('csvCarga') is-invalid @enderror" value="{{ old('csvCarga') }}" placeholder="Seleccione el archivo de carga" accept=".csv">
		        @error('csvCarga')
		            <span class="invalid-feedback" role="alert">
		                <strong>{{ $message }}</strong>
		            </span>
		        @enderror
			</div>	
		</div>
		<div class="form-group row mt-1">
			<div class="col">
				<input type="submit" class="btn btn-xs btn-primary" title="" value="Cargar Productos Planilla"/>
			</div>
		</div>
	</form>
</div>
@endsection
