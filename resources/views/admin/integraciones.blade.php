@extends('admin.principal')

@section('content')
<h2><span class="box-icon"><i class="fas fa-newspaper" aria-hidden="true"></i></span>Integraciones con marketplaces</h2>
<div class="col align-self-center">
	@if(session('exito'))
	    <div class="alert alert-success text-md-center" role="alert">
			{{session('exito')}}
		</div>
	@endif
</div>
<div class="container-fluid mt-3">
	<div class="row">
		<div class="d-flex col">
			<div class="align-items-center text-center">
				<h2><i class="fas fa-exclamation-triangle"></i>Estamos trabajando para usted<i class="fas fa-exclamation-triangle"></i></h2>
			</div>
		</div>
	</div>
</div>
<div class="form-group row mt-1">
	<h4>Servicios de despacho</h4>
	<div class="col col-md-2">
		<a class="btn btn-primary" href="{{route('int.formDatosChE')}}" title="">@if($integraciones->existeIntegracion('chilexpress')) Quitar Chilexpress @else Integrar Chilexpress @endif</a>
	</div>
	<div class="col col-md-2">
		<a class="btn btn-primary" href="{{route('int.formDatosBlE')}}" title="">@if($integraciones->existeIntegracion('Blue Express')) Quitar Blue Express @else Integrar Blue Express @endif</a>
	</div>
</div>
<div class="form-group row mt-1">
	<h4>Marketplaces</h4>
	<div class="col">
		<a class="btn btn-primary" href="{{route('int.formDatosML')}}" title="">Integrar Mercado Libre</a>
	</div>
</div>
@endsection
@section('ajax')
@endsection