<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DailyReportEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $datareport;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($datareport)
    {
        //
        $this->datareport= $datareport;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.users.parent.DailyReport',['data' => $this->datareport])
        ->subject('Reporte Diario')
        ->bcc('jalbornozdesign@gmail.com','jotaeme')
        ->from('no-reply@jardinanatolia.cl','Equipo Anatolia');
    }
}
