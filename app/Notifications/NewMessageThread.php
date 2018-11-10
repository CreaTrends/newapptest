<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use Carbon\Carbon;


use App\User;

class NewMessageThread extends Notification
{
    use Queueable;

    protected $thread;

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
    public function __construct($thread)
    {
        //
        $this->thread=$thread;
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
        $user = User::find(1);
        $subject = $user->profile->first_name.' '.$user->profile->last_name .' te envio un nuevo mensaje';
        return (new MailMessage)
        ->from('no-reply@jardinanatolia.cl','Equipo Anatolia')
        ->subject($subject)
                ->line('Hola '.$user->profile->first_name.', hemos generado una nueva circular informativa de nuestro jardín, te invitamos a leer e informarte de toda las nievedades de nuestro jardín ')
                ->action('Leer Circular', route('apoderado.notes.show',$this->thread->id))
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
            'message' => $this->thread->subject,
            'action' => $this->thread->id,
            'user_id' => $this->thread->user,
        ];
    }
}
