<?php

namespace App\View\Components\Admin\Mantenedores;

use Illuminate\View\Component;

class Usuarios extends Component
{
    public $usuario;
    public $perfiles;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($usuario,$perfiles)
    {
        $this->usuario = $usuario;
        $this->perfiles = $perfiles;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.admin.mantenedores.usuarios');
    }
}
