<?php

declare(strict_types=1);

namespace App\Actions\Chat\Dtos;

use App\Models\Chat;

readonly class ChatMembersActionDTO
{
    public function __construct(
        public Chat $chat,
        public array $userIds
    ){

    }
}
