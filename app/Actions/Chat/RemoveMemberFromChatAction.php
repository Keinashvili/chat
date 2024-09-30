<?php

declare(strict_types=1);

namespace App\Actions\Chat;

use App\Actions\Chat\Dtos\ChatMembersActionDTO;

class RemoveMemberFromChatAction
{
    public function execute(ChatMembersActionDTO $dto): void
    {
        $chat = $dto->chat;
        $chat->user()->detach($dto->userIds);
    }
}
