<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;

class NewMessageMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;


    public $thread;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$thread)
    {
        //
        $this->thread = $thread;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $url = $this->user->hasRole('parent') ? 'apoderado.messages':'admin.messages';
        $route =  route($url);
        

        return $this->view('emails.templates.new_message')
        ->subject('Equipo Jardín Anatolia :: Tienes un nuevo mensaje ')
        ->from('no-reply@mg.jardinanatolia.cl', 'Equipo Jardin Anatolia')
        ->with(['route'=>$route]);
    }
}
