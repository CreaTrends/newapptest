<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Notebook;
use App\User;
use App\Alumno;
class DailyReport extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

     public $user;
     public $child;

    

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($child,$user)
    {
        //
        $this->user = $user;
        $this->child = $child;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = auth()->user();
        return $this->view('emails.templates.new_notebook')
        ->subject('Equipo Jardin Anatolia :: Nueva Libreta diaria de '.$this->child->full_name)
        ->from('no-reply@mg.jardinanatolia.cl', 'Equipo Jardin Anatolia');
        
    }
}
