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

    

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        //
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.reports.daily')
        ->subject('Nuevo Reporte Diario ')
        ->from('no-reply@mg.jardinanatolia.cl', 'Equipo Jardin Anatolia')
        ->replyTo('info@jardinanatolia.cl','Equipo Jardin Anatolia');
    }
}
