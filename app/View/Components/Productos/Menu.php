<?php

namespace App\View\Components\Productos;

use Illuminate\View\Component;

class Menu extends Component
{

    public $producto;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($producto)
    {
        $this->producto = $producto;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.productos.menu');
    }
}
