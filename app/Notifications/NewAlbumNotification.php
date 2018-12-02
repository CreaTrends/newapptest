<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;


use App\Album;
use App\User;

class NewAlbumNotification extends Notification
{
    use Queueable;
    /**
     * Post property.
     *
     * @var \App\Models\Post
     */
    protected $album;
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
    public function __construct(Album $album, $user_id)
    {
        //
        $this->album = $album;
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
        $from = User::findOrFail($this->user_id);
        $to = '';
        $subject = 'Equipo Jardín Anatolia :: Hemos ingresado una nueva galeria';
        return (new MailMessage)
        ->from('no-reply@jardinanatolia.cl','Equipo Anatolia')
        ->subject($subject)
                ->line('Hola Apoderad@, hemos agregado una nueva galeria de imagenes donde fue etiquetado tu hij@ ')
                ->action('Ver Galeria', route('apoderado.album',['id'=>$this->album->album_id,'token'=>$this->album->album_token]))
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
        $from = User::findOrFail($this->user_id);
        $route = $notifiable->hasRole('parent') ? 'apoderado':'admin';
        return [
            'message' => $this->album->album_name,
            'action' => route($route.'.album',['id'=>$this->album->album_id,'token'=>$this->album->album_token]),
            'user_id' => $this->user_id,
        ];
    }
}
