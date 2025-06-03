<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatMessageEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public string $userId;
    public string $roomId;
    public string $type;
    public string $content;
    public int $emotion; // Emotion code, e.g. 0 for neutral, 1 for angry, etc.

    /**
     * Create a new event instance.
     */
    public function __construct(string $userId, string $roomId, string $type, string $content, int $emotion)
{
    $this->userId = $userId;
    $this->roomId = $roomId;
    $this->type = $type;
    $this->content = $content;
    $this->emotion = $emotion;
}

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
  public function broadcastOn(): Channel
{
    return new Channel('chat.' . $this->roomId);
}
public function broadcastAs(): string
    {
        return 'message';
    }
}
