@extends('layouts.main')
@section('contenido')
<div class="container mb-auto" id="content">
	<div class="form-group row mt-1">
	    <div class="col">
	        <label for="nombre" class="label-prod-fg">Nombre</label>
	        <input id="nombre" type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre',$usuario != '' ? $usuario->name : '') }}">
	        @error('nombre')
	            <span class="invalid-feedback" role="alert">
	                <strong>{{ $message }}</strong>
	            </span>
	        @enderror
	    </div>
	</div>
	<div class="form-group row mt-1">
	    <div class="col">
	        <label for="email" class="label-prod-fg">E-mail</label>
	        <input id="email" type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email',$usuario != '' ? $usuario->email : '') }}">
	        @error('email')
	            <span class="invalid-feedback" role="alert">
	                <strong>{{ $message }}</strong>
	            </span>
	        @enderror
	    </div>
	</div>
</div>
@endsection