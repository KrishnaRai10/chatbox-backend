<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserStatusEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $userId;
    public string $roomId;
    public string $status;

    public function __construct(string $userId, string $roomId, string $status)
    {
        $this->userId = $userId;
        $this->roomId = $roomId;
        $this->status = $status;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
   public function broadcastOn(): PresenceChannel
    {
        return new PresenceChannel('chat.' . $this->roomId);
    }

    public function broadcastAs(): string
    {
        return 'status';
    }
}
