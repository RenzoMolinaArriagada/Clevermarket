<div class="form-group row mt-1">
    <div class="col">
        <label for="nombre" class="label-prod-fg">Nombre</label>
        <input id="nombre" type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre',$encuesta != '' ? $encuesta->nombre : '') }}">
        @error('nombre')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col">
        <label for="fechaTer" class="label-prod-fg">Fecha de término</label>
        <input id="fechaTer" type="datetime-local" name="fechaTer" class="form-control @error('fechaTer') is-invalid @enderror" value="{{ old('fechaTer',$encuesta != '' ? date('Y-m-d\TH:i:s',strtotime($encuesta->activo_hasta)) : '') }}">
        @error('fechaTer')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div> 
</div>
<div class="form-group row mt-1">
    <div class="col-xs-12 col-md-2">
        <label for="usosRestantes" class="label-prod-fg">Cantidad de usos</label>
        <input id="usosRestantes" type="text" name="usosRestantes" class="form-control @error('usosRestantes') is-invalid @enderror" value="{{ old('usosRestantes',$encuesta != '' ? $encuesta->usos_restantes : '1') }}">
        @error('usosRestantes')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-xs-12 col-md-3">
        <label for="tipo" class="label-prod-fg">Tipo de encuesta</label>
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