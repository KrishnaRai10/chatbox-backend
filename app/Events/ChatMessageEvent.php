<?php

namespace App\Events;

// use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
class ChatMessageEvent implements ShouldBroadcast
{
    use Dispatchable, SerializesModels,InteractsWithSockets;

    public string $userId;
    public string $roomId;
    public string $type;
    public string $content;
    public int $emotion;

    public function __construct(string $userId, string $roomId, string $type, string $content, int $emotion)
    {
        $this->userId = $userId;
        $this->roomId = $roomId;
        $this->type = $type;
        $this->content = $content;
        $this->emotion = $emotion;
    }

    public function broadcastOn(): Channel
    {
        return new Channel("chat.room.{$this->roomId}");
    }

    public function broadcastAs(): string
    {
        return 'message.sent';
    }
    public function broadcastWith(): array
{
    return [
        'user_id' => $this->userId,
        'room_id' => $this->roomId,
        'type' => $this->type,
        'content' => $this->content,
        'emotion' => $this->emotion,
    ];
}
}
