@extends('admin.principal')

@section('content')
<h2><span class="box-icon"><i class="fas fa-newspaper" aria-hidden="true"></i></span>Integraciones con marketplaces</h2></span>
<h4><span class="box-icon"><img src=""></img></span>Datos para Blue Express</h4>
<div class="col align-self-center">
	@if(session('exito'))
	    <div class="alert alert-success text-md-center" role="alert">
			{{session('exito')}}
		</div>
	@endif
</div>
<form action="{{route('int.setDatosBlE')}}" method="POST" accept-charset="utf-8">
	@csrf
	<div class="form-group row mt-1">
		<div class="col">
			<label for="client_id" class="label-prod-fg">Token</label>
			<input id="client_id" type="text" name="client_id" class="form-control @error('client_id') is-invalid @enderror" value="{{ old('client_id',$intML != NULL ? $intML->client_id : '') }}">
	        @error('client_id')
	            <span class="invalid-feedback" role="alert">
	                <strong>{{ $message }}</strong>
	            </span>
	        @enderror
		</div>
	</div>
	<div class="form-group row mt-1">
		<div class="col">
			<input type="submit" value="Integrar Mercado Libre" class="btn btn-primary" title=""/>
		</div>
	</div>
</form>
@endsection
@section('ajax')
@endsection