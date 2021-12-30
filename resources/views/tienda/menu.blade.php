@extends('layouts.main')
@section('contenido')
<div class="container mb-auto">
	<div class="row mt-1">
		@foreach($productos as $producto)
			<x-productos.menu
			:producto="$producto"
			/>
		@endforeach
		<div class="container mb-auto">
			{{$productos->links()}}
		</div>
	</div>
</div>
@endsection