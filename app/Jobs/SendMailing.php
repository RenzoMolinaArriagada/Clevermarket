<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\Marketing\MailingPublicidad;
use Mail;

class SendMailing implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $headerM;
    public $bodyM;
    public $footerM;
    public $emails;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($headerM,$bodyM,$footerM,$emails)
    {
        $this->headerM = $headerM;
        $this->bodyM = $bodyM;
        $this->footerM = $footerM;
        $this->emails = $emails;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {   
        foreach ($this->emails as $email) {
            Mail::to($email)->send(new MailingPublicidad($this->headerM,$this->bodyM,$this->footerM));
        }
    }
}
