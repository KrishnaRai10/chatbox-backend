<?php
// app/Events/TypingEvent.php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class TypingEvent implements ShouldBroadcast
{
    use SerializesModels;

    public string $userId;
    public string $roomId;

    public function __construct(string $userId, string $roomId)
    {
        $this->userId = $userId;
        $this->roomId = $roomId;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('chat.room.' . $this->roomId);
    }

    public function broadcastAs(): string
    {
        return 'user.typing';
    }
}
