<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\Note;
use App\User;

use App\Mail\WelcomeParent as Mailable;

class NewNoteNotification extends Notification implements ShouldBroadcast,ShouldQueue
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
        return ['mail','database','broadcast'];
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
        $route = $user->hasRole('parent') ? 'apoderado.notes.show':'notes.index';
        $subject = $this->note->user->profile->first_name.' '.$this->note->user->profile->last_name .'';


        //return (new Mailable($user))->to($user->email);


        return (new MailMessage)
        ->from('no-reply@mg.jardinanatolia.cl', 'Equipo Jardin Anatolia')
        ->replyTo($this->note->user->email,$this->note->user->profile->first_name.' '.$this->note->user->profile->last_name)
        ->subject($subject)
                ->line('Hola '.$user->name.', hemos generado una nueva circular informativa de nuestro jardín, te invitamos a leer e informarte de toda las novedades de tu hij@ ')
                ->action('Leer Circular', route($route,$this->note->id))
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
        $route = $notifiable->hasRole('parent') ? 'apoderado.notes.show':'notes.index';
        return [
            'message' => $this->note->subject,
            'action' => route($route,['id'=>$this->note->id]),
            'user_id' => $this->note->user->id,
            'notify-icon' => 'icofont icofont-notepad',
            'notify-bg' => 'is-pink'
        ];
    }
}
