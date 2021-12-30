<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class FormButtons extends Component
{
    public $ruta;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($ruta)
    {
        $this->ruta = $ruta;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.admin.form-buttons');
    }
}
