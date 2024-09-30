<?php

declare(strict_types=1);

namespace App\Services;

use App\Events\UserAddedToChatEvent;
use App\Models\Chat;

class ChatMemberService
{
    public function addMemberToChat(Chat $chat, array $userIds): void
    {
        $chat->user()->sync($userIds);

        foreach ($userIds as $userId) {
            event(
                new UserAddedToChatEvent($chat->id, $userId)
            );
        }
    }
}
