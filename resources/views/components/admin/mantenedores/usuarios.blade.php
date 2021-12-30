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
		<label for="email" class="label-prod-fg">Email</label>
		<input id="email" type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email',$usuario != '' ? $usuario->email : '') }}">
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
	</div>	
</div>
<div class="form-group row mt-1">
	<div class="col">
		<label for="perfil" class="label-prod-fg">Perfil</label>
        <select id="perfil" type="text" class="form-control @error('perfil') is-invalid @enderror" name="perfil" value="{{ old('perfil') }}" autocomplete="perfil" autofocus>
            @if($usuario != '')
            <option disabled value>...</option>
	            @foreach($perfiles as $perfil)
	            	@if($perfil->id == $usuario->perfil)
	            		<option selected value="{{$perfil->id}}">{{$perfil->nombre}}</option>
	            	@else
	            		<option value="{{$perfil->id}}">{{$perfil->nombre}}</option>
	            	@endif
	            @endforeach
	        @else
	        <option disabled selected value>...</option>
	        	@foreach($perfiles as $perfil)
	            	<option value="{{$perfil->id}}">{{$perfil->nombre}}</option>
	            @endforeach    
            @endif
        </select>
        @error('perfil')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
	</div>	
</div>
@if($usuario == '')
<div class="form-group row mt-1">
	<div class="col">
		<label for="password" class="label-prod-fg">Contraseña</label>
		<input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}">
        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
	</div>	
</div>
@endif