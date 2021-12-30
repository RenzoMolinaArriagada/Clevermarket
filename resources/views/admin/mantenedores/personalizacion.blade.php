@extends('admin.principal')

@section('content')
<h2><span class="box-icon"><i class="fas fa-newspaper" aria-hidden="true"></i></span> Configuraciones de personalizacion</h2>
<div class="col align-self-center">
	@if(session('exito'))
	    <div class="alert alert-success text-md-center" role="alert">
			{{session('exito')}}
		</div>
	@endif
</div>
<form action="{{route('custom.cambiarLogo')}}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
	@csrf
	<div class="form-group row mt-5">
		<div class="col">
			<label for="imgLogo" class="label-prod-fg">Logo de la empresa</label>
			<input id="imgLogo" type="file" name="imgLogo" class="form-control border-1 border-secondary p-2 @error('imgLogo') is-invalid @enderror" value="{{ old('imgLogo') }}" placeholder="Seleccione una imagen..." accept="image/x-png,image/gif,image/jpeg,image/webp">
	        @error('imgLogo')
	            <span class="invalid-feedback" role="alert">
	                <strong>{{ $message }}</strong>
	            </span>
	        @enderror
		</div>	
	</div>
	<button type="submit" class="btn btn-primary mt-1 mt-1">
        Guardar logo
    </button>
</form>
<form action="{{route('custom.cambiarBanner')}}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
	@csrf
	<div class="form-group row mt-5">
		<div class="col">
			<label for="imgBanner" class="label-prod-fg">Imagen del banner</label>
			<input id="imgBanner" type="file" name="imgBanner" class="form-control border-1 border-secondary p-2 @error('imgBanner') is-invalid @enderror" value="{{ old('imgBanner') }}" placeholder="Seleccione una imagen..." accept="image/x-png,image/gif,image/jpeg,image/webp">
	        @error('imgBanner')
	            <span class="invalid-feedback" role="alert">
	                <strong>{{ $message }}</strong>
	            </span>
	        @enderror
		</div>	
	</div>
	<button type="submit" class="btn btn-primary mt-1">
        Guardar banner
    </button>
</form>
<form action="{{route('custom.cambiarColorBtns')}}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
	@csrf
	<div class="form-group row mt-5">
		<h4>Color de los botones en la tienda</h4>
	</div>
	<div class="form-group row">
		<div class="col col-md-2">
			<label for="colorBack" class="label-prod-fg">Color de fondo</label>
			@isset($personalizacion)
				<input id="colorBack" type="color" name="colorBack" class="form-control border-1 border-secondary p-2 @error('colorBack') is-invalid @enderror" value="{{ old('colorBack',$personalizacion->color_botones_back) }}" placeholder="Seleccione un color...">
			@else
				<input id="colorBack" type="color" name="colorBack" class="form-control border-1 border-secondary p-2 @error('colorBack') is-invalid @enderror" value="{{ old('colorBack','#0c1429') }}" placeholder="Seleccione un color...">
			@endisset
	        @error('colorBack')
	            <span class="invalid-feedback" role="alert">
	                <strong>{{ $message }}</strong>
	            </span>
	        @enderror
		</div>
		<div class="col col-md-2">
			<label for="colorFront" class="label-prod-fg">Color del texto</label>
			@isset($personalizacion)
				<input id="colorFront" type="color" name="colorFront" class="form-control border-1 border-secondary p-2 @error('colorFront') is-invalid @enderror" value="{{ old('colorFront',$personalizacion->color_botones_front) }}" placeholder="Seleccione un color...">
			@else
				<input id="colorFront" type="color" name="colorFront" class="form-control border-1 border-secondary p-2 @error('colorFront') is-invalid @enderror" value="{{ old('colorFront','#FFFFFF') }}" placeholder="Seleccione un color...">
			@endisset
	        @error('colorFront')
	            <span class="invalid-feedback" role="alert">
	                <strong>{{ $message }}</strong>
	            </span>
	        @enderror
		</div>
	</div>
	<div class="form-group row">
		<div class="col col-md-2">
			<button type="submit" class="btn btn-primary mt-1">
        		Guardar colores
   			</button>
		</div>
		<div class="col col-md-2">
			<button id="btnRestablecerCol" name="btnRestablecerCol" class="btn btn-warning mt-1">
        		Restablecer colores
   			</button>
		</div>
	</div>
</form>
<div class="row">
	<div class="d-flex col">
		<div class="align-items-center text-center">
			<h2><i class="fas fa-exclamation-triangle"></i>Más opciones de personalizacion estan siendo trabajadas<i class="fas fa-exclamation-triangle"></i></h2>
		</div>
	</div>
</div>
@endsection
@section('ajax')
<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

	$('#content').on('click','#btnRestablecerCol',function(){
		event.preventDefault();
		var btnClickeado = $(this);
		var colorBack = $('#colorBack');
		var colorFront = $('#colorFront');
		colorBack.val('#0c1429');
		colorFront.val('#ffffff');
	});

</script>
@endsection