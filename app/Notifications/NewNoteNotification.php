<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use App\Note;
use App\User;

class NewNoteNotification extends Notification
{
    use Queueable;


    /**
     * Post property.
     *
     * @var \App\Models\Post
     */
    protected $note;
    /**
     * User id property.
     *
     * @var integer
     */
    protected $user_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Note $note, $user_id)
    {
        //
        $this->note = $note;
        $this->user_id = $user_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }
/**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $user = User::find($this->user_id);
        $subject = $this->note->user->profile->first_name.' '.$this->note->user->profile->last_name .' te envio una nueva circular';
        return (new MailMessage)
        ->from('no-reply@jardinanatolia.cl','Equipo Anatolia')
        ->subject($subject)
                ->line('Hola '.$user->name.', hemos generado una nueva circular informativa de nuestro jardín, te invitamos a leer e informarte de toda las novedades de tu hij@ ')
                ->action('Leer Circular', route('apoderado.notes.show',$this->note->id))
                ->success();
    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => $this->note->subject,
            'action' => $this->note->id,
            'user_id' => $this->note->user->id,
        ];
    }
}
