<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Contracts\ChatUserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ChatUserRepository implements ChatUserRepositoryInterface
{
    public function getByUserAndChatId(int $userId, int $chatId)
    {
        return DB::table('chat_user')
            ->where('chat_id', '=', $chatId)
            ->where('user_id', '=', $userId)
            ->firstOrFail();
    }
}
