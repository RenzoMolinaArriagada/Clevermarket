@extends('layouts.main')
@section('contenido')
<div class="container mb-auto">
	<div class="row pb-3" id="masVendidos">
		<h4>Mejores productos</h4>
		<x-tienda.recomendados :recomendaciones="$masVendidos"/>
	</div>
	<div class="row pb-3" id="masVistos">
		<h4>Más visitados</h4>
		<x-tienda.recomendados :recomendaciones="$masVistos"/>
	</div>
	<div class="row">
		<div class="d-flex col">
			<div class="align-items-center text-center">
				<h2><i class="fas fa-exclamation-triangle"></i>Sitio en construccion<i class="fas fa-exclamation-triangle"></i></h2>
			</div>
		</div>
	</div>
</div>
@endsection