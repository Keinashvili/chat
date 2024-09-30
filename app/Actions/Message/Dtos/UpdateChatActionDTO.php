<?php

declare(strict_types=1);

namespace App\Actions\Message\Dtos;

use App\Models\Chat;

readonly class UpdateChatActionDTO
{
    public function __construct(
        public Chat $chat,
        public string $name
    ){

    }
}
