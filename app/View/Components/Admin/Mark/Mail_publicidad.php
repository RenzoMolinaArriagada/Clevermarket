<?php

namespace App\View\Components\Admin\Mark;

use Illuminate\View\Component;

class Mail_publicidad extends Component
{
    public $mailing;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($mailing)
    {
        $this->mailing = $mailing;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.admin.mark.mail_publicidad');
    }
}
