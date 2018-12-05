<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use App\Notebook;
use App\User;

class NewNotebook extends Notification
{
    use Queueable;
    /**
     * Post property.
     *
     * @var \App\Models\Post
     */
    protected $notebook;
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
    public function __construct(Notebook $notebook, $user_id)
    {
        //
        $this->notebook = $notebook;
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
        
        $from = User::findOrFail($this->user_id);
        $to = '';
        $subject = $from->profile->first_name.' '.$from->profile->last_name .' te envio un nuevo reporte diario';
        return (new MailMessage)
        ->from('no-reply@jardinanatolia.cl','Equipo Jardín Anatolia')
        ->subject($subject)
                ->line('Hola Papa, hemos agregado un nuevo reporte con las actividades diarias de tu hij@, te invitamos a leer e informarte de toda las novedades de tu hij@ ')
                ->action('Ver Reporte', route('child.feed',$this->notebook->alumno_id))
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
            'message' => $this->notebook->subject,
            'action' => route('child.feed',$this->notebook->alumno_id),
            'user_id' => $this->user_id,
            'notify-icon' => 'fas fa-clipboard-list',
            'notify-bg' => 'is-green',
        ];
    }
}
