<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageEvent implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(
        private readonly Message $message,
        private readonly string $sender,
        private readonly string $broadcastAs,
    ) {

    }

    public function broadcastOn(): Channel
    {
        return new PrivateChannel('chat.' . $this->message->chat_id);
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->message->id,
            'message' => $this->message->message,
            'sender' => $this->sender,
            'status' => $this->message->status,
        ];
    }

    public function broadcastAs(): string
    {
        return $this->broadcastAs;
    }
}
