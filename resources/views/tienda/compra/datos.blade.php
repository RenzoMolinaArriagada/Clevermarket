@extends('layouts.main')
@section('contenido')
<div class="container mb-auto" id="content">
	<div class="d-flex row justify-content-center">
		<div class="col col-md-8">
			<h4>Datos para el despacho</h4>
			<form action="{{route('compra.ingresarCompra')}}" method="POST" accept-charset="utf-8">
				@csrf
				<div class="form-group row mt-1">
					<div class="col">
						<label for="region" class="label-prod-fg">Region</label>
						<select class="form-control" name="region" id="region">
							<option disabled selected>Seleccione su Region</option>
							@foreach($regiones as $region)
								<option value="{{$region->id}}">{{$region->region}}</option>
							@endforeach
						</select>
				        @error('region')
				            <span class="invalid-feedback" role="alert">
				                <strong>{{ $message }}</strong>
				            </span>
				        @enderror
					</div>	
				</div>
				<div class="form-group row mt-1">
					<div class="col">
						<label for="comuna" class="label-prod-fg">Comuna</label>
						<select disabled class="form-control" name="comuna" id="comuna">
							<option id="siempre" disabled selected>Seleccione su comuna</option>
							@foreach($comunas as $comuna)
								<option region="{{$comuna->region_id}}" value="{{$comuna->id}}">{{$comuna->comuna}}</option>
							@endforeach
						</select>
				        @error('comuna')
				            <span class="invalid-feedback" role="alert">
				                <strong>{{ $message }}</strong>
				            </span>
				        @enderror
					</div>	
				</div>
				<div class="form-group row mt-1">
					<div class="col-12 col-md-9">
						<label for="calle" class="label-prod-fg">Calle</label>
						<input id="calle" type="text" name="calle" class="form-control @error('calle') is-invalid @enderror" value="{{ old('calle') }}">
				        @error('calle')
				            <span class="invalid-feedback" role="alert">
				                <strong>{{ $message }}</strong>
				            </span>
				        @enderror
					</div>
					<div class="col-12 col-md-3">
						<label for="numeracion" class="label-prod-fg">Numeración</label>
						<input id="numeracion" type="number" name="numeracion" class="form-control @error('numeracion') is-invalid @enderror" value="{{ old('numeracion') }}">
				        @error('numeracion')
				            <span class="invalid-feedback" role="alert">
				                <strong>{{ $message }}</strong>
				            </span>
				        @enderror
					</div>
				</div>
				<div class="form-group row mt-1">
					<div class="col-12 col-md-9">
						<label for="codigo_descuento" class="label-prod-fg">Código de descuento</label>
						<input id="codigo_descuento" type="text" name="codigo_descuento" class="form-control @error('codigo_descuento') is-invalid @enderror" value="{{ old('codigo_descuento') }}">
				        @error('codigo_descuento')
				            <span class="invalid-feedback" role="alert">
				                <strong>{{ $message }}</strong>
				            </span>
				        @enderror
					</div>	
					<div class="col-12 col-md-3">
						<label for="btnValCodigo" class="label-prod-fg"></label>
						<button id="btnValCodigo" name="btnValCodigo" class="form-control" >Validar Código</button>
					</div>
				</div>
				<div class="form-group row mt-3">
					<button id="verifDireccion" class="flex-fill btn btn-precio-fg" type="submit">Realizar Pedido</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection
@section('ajax')
	<script>
		$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    	});

		$('#content').on('change','#region',function(){
			var regionSeleccionada = this.value;
			$('#comuna').prop('disabled',false);
			$('#comuna option').each(function(){
				var option = $(this);
				if(option.attr('region') === regionSeleccionada){
					option.prop('hidden',false);
					option.prop('disabled',false);
					option.prop('selected',false);
				}
				else{
					option.prop('hidden',true);
					option.prop('disabled',true);
					option.prop('selected',false);
				}
			});
			var optionSiempre = $('#comuna #siempre');
			optionSiempre.prop('hidden',false);
			optionSiempre.prop('selected',true);
		});

		$('#content').on('click','#btnValCodigo',function(){
			event.preventDefault();
			var codigo = $('#codigo_descuento').val();
			if(codigo.length === 0){
				alert('Ingrese un código para validar');
				return;
			}
			else{
				@auth
				var idUser = {{Auth::user()->id}}
				@else
				var idUser = null;
				@endauth
				$.ajax({
			    	type:'POST',
			    	url:"{{ route('compra.verificarCodigo') }}",
			    	data:{codigo:codigo,idUser:idUser,_method:'POST'},
			    	success:function(data){
			    		var res = data.res;
			    		console.log(data.desc);
			    		var inputCodigo = $('#codigo_descuento');
			    		if(res === 'V'){
			    			var btnValidar = $('#btnValCodigo');
			    			inputCodigo.prop('readonly',true);
			    			btnValidar.prop('disabled',true);
			    			btnValidar.html('¡Código Válido!');
			    		}
			    		else{
			    			inputCodigo.val(undefined);
			    			alert('Código Inválido');
			    		}
			    	},
			    	error:function(data){
			    		accion = data.error;
			    		alert("Ha ocurrido un error inesperado " + accion);
			    	}
		   		});
			}
	    });
	</script>
@endsection