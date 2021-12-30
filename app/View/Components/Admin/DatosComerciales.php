<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class DatosComerciales extends Component
{
    public $producto;
    public $marcas;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($producto,$marcas)
    {
        $this->producto = $producto;
        $this->marcas = $marcas;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.admin.datos-comerciales');
    }
}
