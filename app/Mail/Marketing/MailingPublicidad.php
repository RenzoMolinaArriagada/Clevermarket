<?php

namespace App\Mail\Marketing;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailingPublicidad extends Mailable
{
    use Queueable, SerializesModels;

    public $headerM;
    public $bodyM;
    public $footerM;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($headerM,$bodyM,$footerM)
    {
        $this->headerM = $headerM;
        $this->bodyM = $bodyM;
        $this->footerM = $footerM;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.marketing.mailing');
    }
}
