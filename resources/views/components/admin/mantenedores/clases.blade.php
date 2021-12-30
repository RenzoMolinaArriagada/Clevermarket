<div class="form-group row mt-1">
	<div class="col">
		<label for="nombre" class="label-prod-fg">Nombre</label>
		<input id="nombre" type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre',$clase != '' ? $clase->nombre : '') }}">
        @error('nombre')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
	</div>	
</div>
<div class="form-group row mt-1">
	@foreach($categorias as $categoria)
		<div class="col-6 col-md-3">
			<input id="categorias[]" type="checkbox" name="categorias[]" value="{{$categoria->id}}" class="form-check-input @error('categorias') is-invalid @enderror" {{-- value="{{ old('categoria',$clase != '' ? $clase->categoria : '') }}"--}}>
			<label for="categorias[]" class="label-prod-fg form-check-label">{{$categoria->nombre}}</label>
	        @error('categorias')
	            <span class="invalid-feedback" role="alert">
	                <strong>{{ $message }}</strong>
	            </span>
	        @enderror
		</div>	
	@endforeach
</div>