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
    public $game_slug;

    public function __construct($data)
    {
        $this->player_name = $data['player_name'];
        $this->game_slug = $data['game_slug'];
    }

    public function broadcastOn()
    {
            return new Channel($this->game_slug);

    }

    public function broadcastAs()
    {
        return 'gsk-playerjoined';
    }
        
  
}
