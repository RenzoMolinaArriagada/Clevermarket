<div class="form-group row mt-1">
    <div class="col">
        <label for="nombre" class="label-prod-fg">Código</label>
        <input id="nombre" type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre',$codigo != '' ? $codigo->nombre : '') }}">
        @error('nombre')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col">
        <label for="descuento" class="label-prod-fg">Descuento</label>
        <input id="descuento" type="text" name="descuento" class="form-control @error('descuento') is-invalid @enderror" value="{{ old('descuento',$codigo != '' ? $codigo->descuento : '') }}">
        @error('descuento')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div> 
    <div class="col">
        <label for="fechaCad" class="label-prod-fg">Fecha de caducidad</label>
        <input id="fechaCad" type="datetime-local" name="fechaCad" class="form-control @error('fechaCad') is-invalid @enderror" value="{{ old('fechaCad',$codigo != '' ? date('Y-m-d\TH:i:s',strtotime($codigo->activo_hasta)) : '') }}">
        @error('fechaCad')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div> 
</div>
<div class="form-group row mt-1">
    <div class="col-xs-12 col-md-2">
        <label for="usosRestantes" class="label-prod-fg">Cantidad de usos</label>
        <input id="usosRestantes" type="text" name="usosRestantes" class="form-control @error('usosRestantes') is-invalid @enderror" value="{{ old('usosRestantes',$codigo != '' ? $codigo->usos_restantes : '1') }}">
        @error('usosRestantes')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-xs-12 col-md-3">
        <label for="tipo" class="label-prod-fg">Tipo de codigo</label>
        <select name="tipo" class="form-control @error('tipo') is-invalid @enderror" id="tipo">
            <option value="1">Para todo publico</option>
            <option value="0">Para un usuario</option>
        </select>
        @error('tipo')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-xs-12 col-md-7">
        <label for="tipo" class="label-prod-fg">Correo usuario</label>
        <input id="email_descuento" type="email_descuento" name="email_descuento" class="form-control @error('email_descuento') is-invalid @enderror" value="{{ old('email_descuento') }}" disabled>
        @error('email_descuento')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>