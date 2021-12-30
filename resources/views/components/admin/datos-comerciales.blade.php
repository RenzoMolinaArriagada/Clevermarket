<div class="form-group row mt-1">
    <div class="col">
        <label for="sku" class="label-prod-fg">SKU</label>
        <input id="sku" type="text" name="sku" class="form-control @error('sku') is-invalid @enderror" value="{{ old('sku',$producto != '' ? $producto->sku : '') }}">
        @error('sku')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>  
</div>
<div class="form-group row mt-1">
	<div class="col">
		<label for="nombre" class="label-prod-fg">Nombre</label>
		<input id="nombre" type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre',$producto != '' ? $producto->nombre : '') }}">
        @error('nombre')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
	</div>	
</div>
<div class="form-group row mt-1">
	<div class="col">
		<label for="nom_fabricante" class="label-prod-fg">Nombre Fabricante</label>
		<input id="nom_fabricante" type="text" name="nom_fabricante" class="form-control @error('nom_fabricante') is-invalid @enderror" value="{{ old('nom_fabricante',$producto != '' ? $producto->nombre_fabricante : '') }}">
        @error('nom_fabricante')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
	</div>	
</div>
<div class="form-group row mt-1">
	<div class="col">
		<label for="desc" class="label-prod-fg">Descripcion</label>
		<textarea id="desc" type="text" name="desc" class="form-control @error('desc') is-invalid @enderror" value="">{{ old('desc',$producto != '' ? $producto->descripcion : '') }}</textarea>
        @error('desc')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
	</div>	
</div>
<div class="form-group row mt-1">
	<div class="col">
		<label for="marca" class="label-prod-fg">Marca</label>
        <select id="marca" type="text" class="form-control @error('marca') is-invalid @enderror" name="marca" value="{{ old('marca') }}" autocomplete="marca" autofocus>
            @if($producto != '')
            <option disabled value>...</option>
	            @foreach($marcas as $marca)
	            	@if($marca->id == $producto->marca->id)
	            		<option selected value="{{$marca->id}}">{{$marca->nombre}}</option>
	            	@else
	            		<option value="{{$marca->id}}">{{$marca->nombre}}</option>
	            	@endif
	            @endforeach
	        @else
	        <option disabled selected value>...</option>
	        	@foreach($marcas as $marca)
	            	<option value="{{$marca->id}}">{{$marca->nombre}}</option>
	            @endforeach    
            @endif
        </select>
        @error('marca')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
	</div>	
</div>
<div class="form-group row mt-1">
	<div class="col">
		<label for="precio" class="label-prod-fg">Precio</label>
		<input id="precio" type="number" name="precio" class="form-control @error('precio') is-invalid @enderror" value="{{ old('precio',$producto != '' ? $producto->precio : '') }}">
        @error('precio')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
	</div>	
</div>
<div class="form-group row mt-1">
	<div class="col">
		<label for="cantidad" class="label-prod-fg">Cantidad</label>
		<input id="cantidad" type="number" name="cantidad" class="form-control @error('cantidad') is-invalid @enderror" value="{{ old('cantidad',$producto != '' ? $producto->cantidad : '') }}">
        @error('cantidad')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
	</div>	
</div>
<div class="form-group row mt-1">
	<div class="col">
		<label for="imgPrincipal" class="label-prod-fg">Imagen</label>
		<input id="imgPrincipal" type="file" name="imgPrincipal" class="form-control border-1 border-secondary p-2 @error('imgPrincipal') is-invalid @enderror" value="{{ old('imgPrincipal') }}" placeholder="Seleccione una imagen..." accept="image/x-png,image/gif,image/jpeg,image/webp">
        @error('imgPrincipal')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
	</div>	
</div>