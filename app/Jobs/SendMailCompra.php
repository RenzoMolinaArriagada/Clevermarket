<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\Venta\ConfirmacionCompra;
use Mail;

class SendMailCompra implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $carroCompleto;
    protected $precio_total;
    protected $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email,$carroCompleto,$precio_total)
    {
        $this->email = $email;
        $this->carroCompleto = $carroCompleto;
        $this->precio_total = $precio_total;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new ConfirmacionCompra($this->carroCompleto,$this->precio_total));
    }
}
