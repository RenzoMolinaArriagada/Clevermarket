<?php

namespace App\View\Components\Tienda;

use Illuminate\View\Component;

class Recomendados extends Component
{

    public $recomendaciones;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($recomendaciones)
    {
        $this->recomendaciones = $recomendaciones;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.tienda.recomendados');
    }
}
