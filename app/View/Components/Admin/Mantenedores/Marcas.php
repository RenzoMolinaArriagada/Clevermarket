<?php

namespace App\View\Components\Admin\Mantenedores;

use Illuminate\View\Component;

class Marcas extends Component
{
    public $marca;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($marca)
    {
        $this->marca = $marca;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.admin.mantenedores.marcas');
    }
}
