<?php

declare(strict_types=1);

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class UserAddedToChatEvent implements ShouldBroadcast
{
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(
        private readonly int $chatId,
        private readonly int $userId
    ) {

    }

    public function broadcastOn(): Channel
    {
        return new Channel('chat.' . $this->chatId);
    }

    public function broadcastWith(): array
    {
        return [
            'chat_id' => $this->chatId,
            'user_id' => $this->userId,
        ];
    }

    public function broadcastAs(): string
    {
        return 'user.added';
    }
}
