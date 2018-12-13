<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;

class SendActivation extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $newpassword;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user,$newpassword)
    {
        //
        $this->user = $user;
        $this->newpassword = $newpassword;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.templates.send_activation')
        ->subject('Equipo Jardín Anatolia :: Recuerda activar tu cuenta')
        ->from('no-reply@mg.jardinanatolia.cl', 'Equipo Jardin Anatolia');
    }
}
