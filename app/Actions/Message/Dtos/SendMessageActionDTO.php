<?php

declare(strict_types=1);

namespace App\Actions\Message\Dtos;

use App\Models\Chat;

readonly class SendMessageActionDTO
{
    public function __construct(
        public Chat $chat,
        public string $message,
        public string $sender_name,
    ){

    }
}
