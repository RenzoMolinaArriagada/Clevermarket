@extends('admin.principal')

@section('content')
<h2><span class="box-icon"><i class="fas fa-envelope"></i></span> Envío de correos masivos para publicidad</h2>
<div class="col align-self-center">
	@if(session('exito'))
	    <div class="alert alert-success text-md-center" role="alert">
			{{session('exito')}}
		</div>
	@endif
</div>
<div class="container-fluid mt-3">
	<div class="row m-3">
		<div class="col-md-6">
			<a class="btn btn-xs btn-primary m-1" href="{{route('mark.formCreateMailPub')}}">Crear nuevo mailing</a>
		</div>
	</div>
	<div class="row">
		<h4>Mailings creados previamente</h4>
		<table class="table">
			<thead>
				<tr>
					<th>#</th>
					<th>Nombre</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
				@foreach($mailings as $mailing)
				<tr>
					<td>{{$loop->iteration}}</td>
					<td>{{$mailing->nombre}}</td>
					<td>
						<a class="btn btn-xs btn-primary mb-1" href="{{route('mark.formEditMailPub',$mailing)}}">Editar</a>
							<button id="btnSend{{$mailing->id}}" value="{{$mailing->id}}" class="btn btn-xs btn-primary mb-1 btnSendMail" data-bs-toggle="modal" data-bs-target="#modalSendMail" data-bs-mailing="{{$mailing->id}}"><i class="fas fa-paper-plane"></i>  Enviar</button>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		{{ $mailings->links() }}
	</div>
</div>
@endsection
@section('ajax')
<div class="modal fade" id="modalSendMail">
    <div  class="modal-dialog modal-dialog-scrollable modal-lg modal-fullscreen-md-down" aria-hidden="true" tabindex="-1">
        <div class="modal-content">       
            <div class="modal-header">
                <h4>Confirmar Envío</h4>
            </div>
            <div class="modal-body">
                <p style="color:black;">Se enviará el correo a todos los usuarios registrados en la plataforma</p>
                <p style="color:black;">¿Desea continuar?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Cancel')}}</button>
                <form action="{{route('mark.sendMailing')}}" method="post" accept-charset="utf-8">
		        	@csrf
		        	<input type="hidden" name="mailing" id="mailing">
		        	<button  class="btn btn-xs btn-primary mb-1 btnSendMail" type="submit"><i class="fas fa-paper-plane"></i>  Confirmar</button>
				</form>
            </div>
        </div> 
    </div> 
</div>

<script>
	var modalSendMail = document.getElementById('modalSendMail')
	modalSendMail.addEventListener('show.bs.modal', function (event) {
	  // Button that triggered the modal
	  var button = event.relatedTarget;

	  // Extract info from data-bs-* attributes
	  var mailing_id = button.getAttribute('data-bs-mailing');

	  // If necessary, you could initiate an AJAX request here
	  // and then do the updating in a callback.
	  //
	  // Update the modal's content.
	  var modalMailingInput = modalSendMail.querySelector('.modal-footer #mailing');
	  modalMailingInput.value = mailing_id;
	});
</script>
@endsection