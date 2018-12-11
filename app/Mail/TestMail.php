<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TestMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    

    public function __construct()
    {
        
    }

    public function build()
    {
        $address = 'no-reply@mg.jardinanatolia.cl';
        $subject = 'This is a demo! for queue';
        $name = 'jardin test mailing';
        
        return $this->view('email.test')
                    ->from($address, $name)
                    ->subject($subject)
    }

}
