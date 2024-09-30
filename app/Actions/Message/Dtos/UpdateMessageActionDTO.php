<?php

declare(strict_types=1);

namespace App\Actions\Message\Dtos;

use App\Models\Message;

readonly class UpdateMessageActionDTO
{
    public function __construct(
        public Message $message,
        public string $message_text,
        public string $sender_name
    ){

    }
}
