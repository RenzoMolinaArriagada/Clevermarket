<div class="row">
	<div class="col-6">
		<img class="img-prodprincipal-fg img-fluid" src="{{asset($producto->imagen_principal)}}">
	</div>
	<div class="col-6">
		<div class="row">
			<div class="col-12">
				<label for="nomprod" class="label label-prod-fg">Nombre</label>
			</div>
			<div class="col-12 ml-3">
				<p id="nomprod">{{$producto->nombre}}</p>
			</div>	
		</div>
		<div class="row">
			<div class="col-12">
				<label for="marcaprod" class="label label-prod-fg">Marca</label>
			</div>
			<div class="col-12 ml-3">
				<p id="marcaprod">{{$producto->marca->nombre}}</p>
			</div>
		</div>
{{-- 		<div class="row">
			<div class="col-12">
				<label for="tipo" class="label label-prod-fg">Tipo de Luz</label>
			</div>
			<div class="col-12 ml-3">
				<p id="tipo">{{$producto->tipoLuz->nombre}}</p>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<label for="tipo" class="label label-prod-fg">Conexión y Uso ideal</label>
			</div>
			<div class="col-12 ml-3">
				<p id="tipo">
					@foreach($producto->tipoProducto as $tipo)
						@if($loop->last)
							{{$tipo->nombre}}
						@else
							{{$tipo->nombre}} -
						@endif
					@endforeach
				</p>
			</div>
		</div> --}}
		<div class="row">
			<div class="col-12">
				<label for="tipo" class="label label-prod-fg">Disponibilidad</label>
			</div>
			<div class="col-12 ml-3">
				<p id="tipo">{{$producto->cantidad}} en stock.</p>
			</div>
		</div>
		<div class="row">
			<x-tienda.compra-carro
			:producto="$producto"
			/>
			<div class="col-12 ml-3">
				<p>Medios de pago</p>
				<ul class="nav">
					<li class="nav-item">RedCompra</li>
					<li class="nav-item">Visa</li>
					<li class="nav-item">MasterCard</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="d-flex justify-content-center">
		
			<ul class="nav nav-pills pills-fg" id="tabProductos" role="tablist">
				<li class="nav-item" role="presentation">
			    	<button class="nav-link active" id="ficha-tab" data-bs-toggle="tab" data-bs-target="#ficha" type="button" role="tab" aria-controls="ficha" aria-selected="true">Ficha Tecnica</button>
				</li>
				<li class="nav-item" role="presentation">
			    	<button class="nav-link" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc" type="button" role="tab" aria-controls="desc" aria-selected="false">Descripción</button>
				</li>
			</ul>
		
	</div>
	<div class="tab-content" id="tabProductosContent">
	  <div class="tab-pane fade show active" id="ficha" role="tabpanel" aria-labelledby="ficha-tab">
	  	<div class="d-flex justify-content-center">
	  		<div class="col col-md-6">
		  		<table class="table table-bordered border-primary">
			  		<tbody>
			  			@if($producto->ficha != null)
				  			@if($producto->ficha->dpi_min != null)
					  			<tr>
					  				<th>Dpi Minimo</th>
					  				<td>{{$producto->ficha->dpi_min}}</td>
					  			</tr>
				  			@endif
				  			@if($producto->ficha->dpi_max != null)
					  			<tr>
					  				<th>Dpi Maximo</th>
					  				<td>{{$producto->ficha->dpi_max}}</td>
					  			</tr>
				  			@endif
				  			@if($producto->ficha->botonesProgramables != null)
					  			<tr>
					  				<th>Botones Programables</th>
					  				<td>{{$producto->ficha->botonesProgramables}}</td>
					  			</tr>
				  			@endif
				  			@if($producto->ficha->alto != null)
					  			<tr>
					  				<th>Botones Programables</th>
					  				<td>{{$producto->ficha->alto}}</td>
					  			</tr>
				  			@endif
				  			@if($producto->ficha->largo != null)
					  			<tr>
					  				<th>Botones Programables</th>
					  				<td>{{$producto->ficha->largo}}</td>
					  			</tr>
				  			@endif
				  			@if($producto->ficha->ancho != null)
					  			<tr>
					  				<th>Botones Programables</th>
					  				<td>{{$producto->ficha->ancho}}</td>
					  			</tr>
				  			@endif
				  			@if($producto->ficha->largoCable != null)
					  			<tr>
					  				<th>Botones Programables</th>
					  				<td>{{$producto->ficha->largoCable}}</td>
					  			</tr>
				  			@endif
				  			@if($producto->ficha->peso != null)
					  			<tr>
					  				<th>Botones Programables</th>
					  				<td>{{$producto->ficha->peso}}</td>
					  			</tr>
				  			@endif
			  			@endif
			  		</tbody>
			  	</table>
	  		</div>
	  	</div>
	  </div>
	  <div class="tab-pane fade" id="desc" role="tabpanel" aria-labelledby="desc-tab">{!! $producto->descripcion !!}</div>
	</div>
</div>