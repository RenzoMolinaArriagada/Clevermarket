<div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
  	 @foreach($recomendaciones->chunk(4) as $bloque)
        @if($loop->index == 0)                        
            <div class="carousel-item active">
                <div class="row">
                @foreach($bloque as $producto)
	                <x-productos.menu
	                	:producto="$producto"
					/>
                @endforeach   
                </div>
            </div>
        @else
            <div class="carousel-item">
                <div class="row">
                @foreach($bloque as $producto)
	                <x-productos.menu
	                	:producto="$producto"
					/>
                @endforeach    
                </div>
            </div>
        @endif
    @endforeach
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>