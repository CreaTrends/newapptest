<?php

namespace App\Events;
use App\Note;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class StatusLiked implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $note;

    public $user;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Note $note,User $user)
    {
        $this->note = $note;
        $this->user = $user;
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('chat');
    }
    public function broadcastWith()
    {
      return [
        'body' => $this->note->id,
        'created_at' => $this->note->subject,
        'user' => [
          'name' => $this->note->user->name,
          'avatar' => 'http://lorempixel.com/50/50'
        ]
      ];
    }

}
