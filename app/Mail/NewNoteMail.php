<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Note;
use App\User;
class NewNoteMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $note;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Note $note,$user)
    {
        //
        $this->user = $user;
        $this->note = $note;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = User::find($this->note->user_id);

        $url = $this->user->hasRole('parent') ? 'apoderado.notes.show':'notes.index';
        $route =  route($url,$this->note->id);
        
        $subject = $user->profile->full_name.' Envio una nueva circular';

        return $this->view('emails.templates.new_note')
        ->subject($subject)
        ->from('no-reply@mg.jardinanatolia.cl', 'Equipo Jardin Anatolia')
        ->with(['url'=>$route])
        ->replyTo($this->note->user->email,$user->profile->full_name);
    }
}
