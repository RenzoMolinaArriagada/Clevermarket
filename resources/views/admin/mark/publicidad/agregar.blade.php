@extends('admin.principal')

@section('content')
<h2><span class="box-icon"><i class="fas fa-envelope"></i></span> Envío de correos masivos para publicidad</h2>
@if(!isset($mailing))
	<h4>Creando un nuevo mail</b></h4>
@else
	<h4>Editando el mail {{$mailing->nombre}}</b></h4>
@endif
<div class="col align-self-center">
	@if(session('exito'))
	    <div class="alert alert-success text-md-center" role="alert">
			{{session('exito')}}
		</div>
	@endif
</div>
<div class="container-fluid mt-3">
	@if(!isset($mailing))
	<div class="row">
		<form id="formMail" action="{{route('mark.createMailPub')}}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
			@csrf
			<x-admin.mark.mail_publicidad
				:mailing="''"
			/>
			<x-admin.form-buttons
				:ruta="route('admin.emailPublicidad')"
			/>	
		</form>
		<img src="" id="imgTest">
	</div>
	@else
		<div class="row">
			<form id="formMail" action="{{route('mark.editMailPub',$mailing)}}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
				@csrf
				<x-admin.mark.mail_publicidad
					:mailing="$mailing"
				/>
				<x-admin.form-buttons
					:ruta="route('admin.emailPublicidad')"
				/>	
			</form>
			<img src="" id="imgTest">
		</div>
	@endif
</div>
@endsection
@section('ajax')
<script>	
	function readURL(input,output) {
	    if (input.prop('files') && input.prop('files')[0]) {
	        var reader = new FileReader();

	        reader.onload = function (e) {
	            output.attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.prop('files')[0]);
	    }
	}

	function sinHeader(){
		$('#textareaHeader').prop('disabled',true);
		$('#textareaHeader').prop('hidden',true);
		$('#textareaHeader').val(null);
		$('#imgHeader').prop('disabled',true);
		$('#imgHeader').prop('hidden',true);
	}

	function textHeader(){
		$('#textareaHeader').prop('disabled',false);
		$('#textareaHeader').prop('hidden',false);
		$('#imgHeader').prop('disabled',true);
		$('#imgHeader').prop('hidden',true);
	}

	function imageHeader(){
		$('#textareaHeader').prop('disabled',true);
		$('#textareaHeader').prop('hidden',true);
		$('#textareaHeader').val(null);
		$('#imgHeader').prop('disabled',false);
		$('#imgHeader').prop('hidden',false);
	}

	function textBody(){
		$('#textareaBody').prop('disabled',false);
		$('#textareaBody').prop('hidden',false);
		$('#imgBody').prop('disabled',true);
		$('#imgBody').prop('hidden',true);
	}

	function imageBody(){
		$('#textareaBody').prop('disabled',true);
		$('#textareaBody').prop('hidden',true);
		$('#textareaBody').val(null);
		$('#imgBody').prop('disabled',false);
		$('#imgBody').prop('hidden',false);
	}

	function sinFooter(){
		$('#textareaFooter').prop('disabled',true);
		$('#textareaFooter').prop('hidden',true);
		$('#textareaFooter').val(null);
		$('#imgFooter').prop('disabled',true);
		$('#imgFooter').prop('hidden',true);
	}

	function textFooter(){
		$('#textareaFooter').prop('disabled',false);
		$('#textareaFooter').prop('hidden',false);
		$('#imgFooter').prop('disabled',true);
		$('#imgFooter').prop('hidden',true);
	}

	function imageFooter(){
		$('#textareaFooter').prop('disabled',true);
		$('#textareaFooter').prop('hidden',true);
		$('#textareaFooter').val(null);
		$('#imgFooter').prop('disabled',false);
		$('#imgFooter').prop('hidden',false);
	}

	$('#content').on('click','#sinHeader',function(){
		sinHeader();
	});

	$('#content').on('click','#textHeader',function(){
		textHeader();
	});

	$('#content').on('click','#imageHeader',function(){
		imageHeader();
	});

	$('#content').on('click','#textBody',function(){
		textBody();
	});

	$('#content').on('click','#imageBody',function(){
		imageBody();
	});

	$('#content').on('click','#sinFooter',function(){
		sinFooter();
	});

	$('#content').on('click','#textFooter',function(){
		textFooter();
	});

	$('#content').on('click','#imageFooter',function(){
		imageFooter();
	});

	$('#content').on('click','#modalVP',function(){
		var radioHeader = $("input[name='radio_Header']:checked").val();
		var radioBody = $("input[name='radio_Body']:checked").val();
		var radioFooter = $("input[name='radio_Footer']:checked").val();
		switch(radioHeader){
			case "0":
				sinHeader();
				$('#tdHeaderText').html("");
				break;
			case "1":
				textHeader();
				$('#tdHeaderText').html($('#textareaHeader').val());
				break;
			case "2":
				imageHeader();
				$('#tdHeaderText').html("<img id='headerImg' style='max-height:150px;margin-left:auto;margin-right:auto'> ");
				readURL($("#imgHeader"),$('#headerImg'));
				break;
		}
		switch(radioBody){
			case "1":
				textBody();
				$('#tdBodyText').html($('#textareaBody').val());
				break;
			case "2":
				imageBody();
				$('#tdBodyText').html("<img id='bodyImg' style='margin-left:auto;margin-right:auto'>");
				readURL($("#imgBody"),$('#bodyImg'));
				break;
		}
		switch(radioFooter){
			case "0":
				sinFooter();
				$('#tdFooterText').html("");
				break;
			case "1":
				textFooter();
				$('#tdFooterText').html($('#textareaFooter').val());
				break;
			case "2":
				imageFooter();
				$('#tdFooterText').html("<img id='footerImg' style='margin-left:auto;margin-right:auto'>");
				readURL($("#imgFooter"),$('#footerImg'));
				break;
		}
	});

</script>	
@endsection