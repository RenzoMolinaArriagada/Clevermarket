<?php

namespace App\Mail\Venta;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmacionCompra extends Mailable
{
    use Queueable, SerializesModels;

    public $carroCompleto;
    public $precio_total;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($carroCompleto,$precio_total)
    {
        $this->carroCompleto = $carroCompleto;
        $this->precio_total = $precio_total;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.venta.confirmacion');
    }
}
