@extends('admin.principal')

@section('content')
<h2><span class="box-icon"><i class="fas fa-medal"></i></span> Codigos de descuento para clientes</h2>
<h4>Creando un nuevo código</b></h4>
<div class="col align-self-center">
	@if(session('exito'))
	    <div class="alert alert-success text-md-center" role="alert">
			{{session('exito')}}
		</div>
	@endif
</div>
<div class="container-fluid mt-3">
	<div class="row">
		<div class="col">
			<p>Para crear un nuevo código de descuento debe tener en cuenta las siguientes consideraciones:
			<ul class="mr-3">
				<li>El nombre del codigo debe tener al menos 4 carateceres.</li>
				<li>El Descuento debe ser escrito en decimales. Ej: 0.20</li>
				<li>La fecha de caducidad determina cuando el codigo deja de estar activo.</li>
				<li>La cantidad de usos se puede determinar como infinita escribiendo -1</li>
				<li>El tipo de codigo determina si cualquier persona de la plataforma puede usarlo o si debe indicar a que usuario le pertenece</li>
			</ul>
			</p>
		</div>
	</div>
	<div class="row">
		<form action="{{route('fid.createCodigoDescuento')}}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
			@csrf
			<x-admin.fidelizacion.codigos_descuento
				:codigo="''"
			/>
			<x-admin.form-buttons
				:ruta="route('fid.createCodigoDescuento')"
			/>	
		</form>
	</div>
</div>
@endsection
@section('ajax')
<script		>	
	$('#content').on('change','#tipo',function(){
			var tipoSeleccionado = this.value;
			var inputCorreo = $('#email_descuento');
			if(tipoSeleccionado == 0){
				inputCorreo.prop('disabled',false);
			}else{
				inputCorreo.prop('disabled',true);
			}
		});
</script>	
@endsection