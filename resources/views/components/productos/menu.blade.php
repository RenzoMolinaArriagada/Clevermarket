<div class="col-lg-3 col-sm-6 col-6 text-center">
	<div class="menu-border-fg rounded-3">
		{{$producto->nombre}}
		<img src="{{asset($producto->imagen_principal)}}" class="img-menu-fg mx-auto">
		<a href="{{route('productos.vistaProducto',['clase' => $producto->clase, 'producto' => $producto])}}" class="btn btn-precio-fg">${{number_format($producto->precio,0)}}</a>
	</div>
</div>