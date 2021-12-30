<?php

namespace App\View\Components\Admin\Mantenedores;

use Illuminate\View\Component;

class Clases extends Component
{
    public $clase;
    public $categorias;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($clase,$categorias)
    {
        $this->clase = $clase;
        $this->categorias = $categorias;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.admin.mantenedores.clases');
    }
}
