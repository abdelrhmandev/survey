<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AdminNextQuestion implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $game_slug;
    public $message;
    public $isFinished;

    public function __construct($data)
    {
        $this->game_slug = $data['game_slug'];
        $this->message = $data['refresh'];
        $this->isFinished = $data['isFinished'];
    }

    public function broadcastOn()
    {
            return new Channel($this->game_slug);

    }

    public function broadcastAs()
    {
        return 'admin-next-question';
    }
        
    // public function broadcastWith()
    // {
        
    // }
}
