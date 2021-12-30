@extends('layouts.main')
@section('contenido')
<div class="container mb-auto" id="contenidoProductos">
	<x-productos.producto 
		:producto="$producto"
	/>		
</div>
@endsection
@section('ajax')
	<script type="text/javascript">
		$.ajaxSetup({
	        headers: {
	            	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        	}
   		});

		$('#contenidoProductos').on('click','#btn-iniciarsesion-modal-fg',function(){
			event.preventDefault();
			var usuario = $('#email').val();
			var pass = $('#password').val();
			var btnClickeado = $(this);
		    $.ajax({
		    	type:'POST',
		    	url:"{{ route('loginAjax') }}",
		    	data:{email:usuario,password:pass,_method:'POST'},
		    	success:function(data){
		    		location.reload();
		    	},
		    	error:function(data){
		    		alert("El usuario o contraseña son erroneos, intente nuevamente");
		    	}
		    });
		});

		$('#contenidoProductos').on('click','#btn-agregarcarro-fg',function(){
			event.preventDefault();
			var idProducto = {{$producto->id}};
			@if(Auth::check())
				var idUser = {{Auth::user()->id}};
			@endif
			var btnClickeado = $(this);
		    $.ajax({
		    	type:'POST',
		    	url:"{{ route('carro.agregar') }}",
		    	data:{idProducto:idProducto,idUser:idUser,_method:'POST'},
		    	success:function(data){
		    		location.reload();
		    		estado = data.success;
		    		console.log(estado);
		    	},
		    	error:function(data){
		    		estado = data.error;
		    		console.log(estado);
		    		alert("Algo fallo en el proceso, por favor contactenos para solucionar su problema a la brevedad");
		    	}
		    });
		});
	</script>
@endsection