<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\ChatTypeEnum;
use App\Models\Chat;
use Illuminate\Support\Facades\DB;

class ChatService
{
    public function getChatName(array $memberIds): string
    {
        $memberNames = DB::table('users')
            ->whereIn('id', $memberIds)
            ->pluck('name')
            ->toArray();

        return implode(', ', $memberNames);
    }

    public function createGroupChat(string $chatName): Chat
    {
        $chat = new Chat();

        $chat->name = $chatName;
        $chat->type = ChatTypeEnum::GROUP->value;
        $chat->save();

        return $chat;
    }
}
