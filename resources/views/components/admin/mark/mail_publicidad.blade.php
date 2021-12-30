<div class="form-group row mt-1 mb-1">
    <div class="col">
        <label for="nombre" class="label-prod-fg">Nombre Mailing</label>
        <input {{$mailing != '' ? 'readonly' : ''}} id="nombre" type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre',$mailing != '' ? $mailing->nombre : '') }}">
        @error('nombre')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="form-group row mt-1">
    <div class="col">
        <label for="header" class="label-prod-fg">Cabecera</label>
        <input type="radio" id="sinHeader" name="radio_Header" value="0" class="form-check-input">
        <label for="sinHeader" class="form-check-label">Sin Cabecera</label>
        <input type="radio" id="textHeader" name="radio_Header" value="1" class="form-check-input" checked> 
        <label for="textHeader" class="form-check-label">Sólo texto</label>
        <input type="radio" id="imageHeader" name="radio_Header" value="2" class="form-check-input">
        <label for="imageHeader" class="form-check-label">Sólo Imagen</label> 
        <textarea id="textareaHeader" type="text" name="textareaHeader" class="form-control @error('header') is-invalid @enderror" value="{{ old('header',$mailing != '' ? $mailing->header : '') }}"></textarea>
        @error('header')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        <input id="imgHeader" type="file" name="imgHeader" class="form-control border-1 border-secondary p-2 @error('imgHeader') is-invalid @enderror" value="{{ old('imgHeader') }}" placeholder="Seleccione una imagen..." accept="image/x-png,image/gif,image/jpeg,image/webp" hidden disabled>
        @error('imgHeader')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="form-group row mt-1">
    <div class="col">
        <label for="body" class="label-prod-fg">Cuerpo</label>
        <input type="radio" id="textBody" name="radio_Body" value="1" class="form-check-input" checked> 
        <label for="textBody" class="form-check-label">Sólo texto</label>
        <input type="radio" id="imageBody" name="radio_Body" value="2" class="form-check-input">
        <label for="imageBody" class="form-check-label">Sólo Imagen</label> 
        <textarea id="textareaBody" type="text" name="textareaBody" class="form-control @error('body') is-invalid @enderror" value="{{ old('body',$mailing != '' ? $mailing->body : '') }}"></textarea>
        @error('body')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        <input id="imgBody" type="file" name="imgBody" class="form-control border-1 border-secondary p-2 @error('imgBody') is-invalid @enderror" value="{{ old('imgBody') }}" placeholder="Seleccione una imagen..." accept="image/x-png,image/gif,image/jpeg,image/webp" hidden disabled>
        @error('imgBody')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="form-group row mt-1">
    <div class="col">
        <label for="footer" class="label-prod-fg">Pie del correo</label>
        <input type="radio" id="sinFooter" name="radio_Footer" value="0" class="form-check-input">
        <label for="sinFooter" class="form-check-label">Sin Pie</label>
        <input type="radio" id="textFooter" name="radio_Footer" value="1" class="form-check-input" checked> 
        <label for="textFooter" class="form-check-label">Sólo texto</label>
        <input type="radio" id="imageFooter" name="radio_Footer" value="2" class="form-check-input">
        <label for="imageFooter" class="form-check-label">Sólo Imagen</label> 
        <textarea id="textareaFooter" type="text" name="textareaFooter" class="form-control @error('footer') is-invalid @enderror" value="{{ old('footer',$mailing != '' ? $mailing->footer : '') }}"></textarea>
        @error('footer')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        <input id="imgFooter" type="file" name="imgFooter" class="form-control border-1 border-secondary p-2 @error('imgFooter') is-invalid @enderror" value="{{ old('imgFooter') }}" placeholder="Seleccione una imagen..." accept="image/x-png,image/gif,image/jpeg,image/webp" hidden disabled>
        @error('imgFooter')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="form-group row mt-1">
    <div class="col">
        <button id="modalVP" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalVistaPrevia">Vista Previa</button>
    </div>
</div>
<div class="modal fade" id="modalVistaPrevia">
    <div  class="modal-dialog modal-dialog-scrollable modal-lg modal-fullscreen-md-down" aria-hidden="true" tabindex="-1">
        <div class="modal-content">       
            <div class="modal-header">
                <h4>Vista Previa</h4>
            </div>
            <div class="modal-body">
                <table style="max-width:600px;width:100%;border:none">
                    <tbody>
                        <tr>
                            <td id="tdHeaderText" style="text-align:center;max-width:500px;max-height: 150px;"></td>
                        </tr>
                        <tr>
                            <td id="tdBodyText" style="text-align:center;max-width:500px"></td>
                        </tr>
                        <tr>
                            <td id="tdFooterText" style="text-align:center;max-width:500px;"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
            </div>
        </div> 
    </div> 
</div>

