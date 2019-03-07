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
        return ['database'];
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
            'message' => User::find($this->user_id)->profile->first_name.' ingreso un nuevo reporte diario',
            'action' => route('child.feed',$this->notebook->alumno_id),
            'user_id' => $this->user_id,
            'notify-icon' => 'fas fa-clipboard-list',
            'notify-bg' => 'is-green',
        ];
    }
}
