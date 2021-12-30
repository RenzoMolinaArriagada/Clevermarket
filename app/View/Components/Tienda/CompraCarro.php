<?php

namespace App\View\Components\Tienda;

use Illuminate\View\Component;

class CompraCarro extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $producto;
    
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
        return view('components.tienda.compra-carro');
    }
}
