<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PlayerJoined implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $player_name;

    public function __construct($data)
    {
        $this->player_name = $data['player_name'];
    }

    public function broadcastOn()
    {
            return new Channel('gsk-playerjoined.'.$this->player_name);

    }

    public function broadcastAs()
    {
        return 'gsk-playerjoined';
    }
        
  
}
