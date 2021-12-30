@extends('admin.principal')

@section('content')
<h2><span class="box-icon"><i class="fas fa-bullhorn"></i></span> Creación de encuestas para la plataforma.</h2>
<h4>Creando una nueva encuesta</b></h4>
<div class="col align-self-center">
	@if(session('exito'))
	    <div class="alert alert-success text-md-center" role="alert">
			{{session('exito')}}
		</div>
	@endif
</div>
<div class="container-fluid mt-3">
	<div class="row">
		<form action="{{route('mark.createEncuesta')}}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
			@csrf
			<x-admin.mark.encuestas
				:encuesta="''"
			/>
			<x-admin.form-buttons
				:ruta="route('mark.createEncuesta')"
			/>	
		</form>
	</div>
</div>
@endsection
@section('ajax')
<script>	

</script>	
@endsection