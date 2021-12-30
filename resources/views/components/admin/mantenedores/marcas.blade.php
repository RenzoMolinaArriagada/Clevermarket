<div class="form-group row mt-1">
    <div class="col">
        <label for="nombre" class="label-prod-fg">Nombre</label>
        <input id="nombre" type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre',$marca != '' ? $marca->nombre : '') }}">
        @error('nombre')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>  
</div>