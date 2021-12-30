@extends('admin.principal')

@section('content')
<h2><span class="box-icon"><i class="fas fa-newspaper" aria-hidden="true"></i></span> Mantenedor de Auditoria</h2>
<div class="col align-self-center">
	@if(session('exito'))
	    <div class="alert alert-success text-md-center" role="alert">
			{{session('exito')}}
		</div>
	@endif
</div>
<div class="container-fluid mt-3">
	<div class="row">
		<h4>Acciones en el sistema:</h4>
		<form action="{{route('admin.manAudits')}}" class="m-3">
			<legend><i class="fas fa-filter"></i> Filtros de la tabla</legend>
			<div class="row">
				<div class="col">
					<div class="mb-3">
					    <label for="audit_email" class="form-label">Usuario</label>
					    <input type="email" class="form-control" id="audit_email" name="audit_email">
					  </div>
				</div>
				<div class="col">
					<div class="mb-3">
					    <label for="audit_perfil" class="form-label">Perfil</label>
					    <select class="form-control" id="audit_perfil" name="audit_perfil">
					    	<option selected disabled>...</option>
					    	<option value="1">Administrador</option>
					    	<option value="2">Vendedor</option>
					    	<option value="3">Cliente</option>
					    	<option value="4">Soporte</option>
					    	<option value="5">Invitado</option>
					    </select>
					  </div>
				</div>
				<div class="col">
					<div class="mb-3">
					    <label for="audit_modulo" class="form-label">Modulo</label>
					    <input type="text" class="form-control" id="audit_modulo" name="audit_modulo">
					  </div>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<div class="mb-3">
					    <label for="audit_accion" class="form-label">Accion Realizada</label>
					    <input type="text" class="form-control" id="audit_accion" name="audit_accion">
					  </div>
				</div>
				<div class="col">
					<div class="mb-3">
					    <label for="audit_estado" class="form-label">Estado</label>
					    <select class="form-control" id="audit_estado" name="audit_estado">
					    	<option selected disabled>...</option>
					    	<option value="completado">Completado</option>
					    	<option value="create">Creación</option>
					    	<option value="edit">Actualización</option>
					    	<option value="delete">Eliminación</option>
					    	<option value="error">Errores</option>
					    </select>
					  </div>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<div class="mb-3">
					    <label for="audit_fechaini" class="form-label">Fecha Inicio</label>
					    <input type="date" class="form-control" id="audit_fechaini" name="audit_fechaini">
					  </div>
				</div>
				<div class="col">
					<div class="mb-3">
					    <label for="audit_fechahasta" class="form-label">Fecha Termino</label>
					    <input type="date" class="form-control" id="audit_fechahasta" name="audit_fechahasta">
					  </div>
				</div>
			</div>
		  <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filtrar</button>
		</form>
		<table class="table">
			<thead>
				<tr>
					<th>#</th>
					<th>Usuario</th>
					<th>Perfil</th>
					<th>Modulo</th>
					<th>Accion Realizada</th>
					<th>Estado</th>
					<th>Fecha</th>
				</tr>
			</thead>
			<tbody>
				@foreach($audits as $audit)
				<tr>
					<td>{{($audits->currentpage()-1) * $audits->perpage() + $loop->iteration}}</td>
					<td>{{$audit->user_id}}</td>
					<td>{{$audit->perfil->nombre}}</td>
					<td>{{$audit->modulo}}</td>
					<td>{{$audit->funcion}}</td>
					<td>{{$audit->status}}</td>
					<td>{{$audit->created_at}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		{{ $audits->links() }}
	</div>
</div>
@endsection
@section('ajax')
@endsection