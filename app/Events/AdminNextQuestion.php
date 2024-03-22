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

    public $question_id;
    public $game_id;

    public function __construct($data)
    {
        $this->question_id = $data['question_id'];
        $this->game_id = $data['game_id'];
    }

    public function broadcastOn()
    {
        return new Channel('admin-next-question');
    }

    public function broadcastAs()
    {
        return 'admin-next-question';
    }
        
    // public function broadcastWith()
    // {
        
    // }
}
