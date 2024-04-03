<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AdminShowAnswer implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $game_slug;
    public $showcorrectanswer;
 

    public function __construct($data)
    {
        $this->game_slug            = $data['game_slug'];
        $this->showcorrectanswer   = $data['showcorrectanswer'];
      
    }

    public function broadcastOn()
    {
            return new Channel('gsk-admin-showanswer-'.$this->game_slug);

    }

    public function broadcastAs()
    {
        return 'admin-showanswer';
    }
        
    // public function broadcastWith()
    // {
        
    // }
}
