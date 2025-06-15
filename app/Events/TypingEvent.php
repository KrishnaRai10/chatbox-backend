<?php
// app/Events/TypingEvent.php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
class TypingEvent implements ShouldBroadcast
{
    use SerializesModels,InteractsWithSockets,Dispatchable;

    public string $userId;
    public string $roomId;
    public string $userAvatar;

    public function __construct(string $userId, string $roomId,string $userAvatar)
    {
        $this->userId = $userId;
        $this->roomId = $roomId;
        $this->userAvatar = $userAvatar;
    }

    public function broadcastOn(): Channel
    {
        return new Channel("chat.room.{$this->roomId}");
    }

    public function broadcastAs(): string
    {
        return 'user.typing';
    }
        public function broadcastWith(): array
{
    return [
        'user_id' => $this->userId,
        'room_id' => $this->roomId,
        'avatar' => $this->userAvatar,
    ];
}
}
