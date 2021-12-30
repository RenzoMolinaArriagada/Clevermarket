<?php

namespace App\View\Components\Admin\Mark;

use Illuminate\View\Component;

class Encuestas extends Component
{
    public $encuesta;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($encuesta)
    {
        $this->encuesta = $encuesta; 
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.admin.mark.encuestas');
    }
}
