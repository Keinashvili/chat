<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Chat;
use App\Repositories\Contracts\ChatRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use stdClass;

class ChatRepository implements ChatRepositoryInterface
{
    public function findOrFail(int $id): Chat
    {
        return Chat::query()->findOrFail($id);
    }

    public function getAll(): Collection
    {
        $authUserId = Auth::id();

        return DB::table('chats')
            ->select(
                'chats.id',
                DB::raw("
                    CASE
                        WHEN chats.name IS NULL THEN (
                            SELECT GROUP_CONCAT(u.name)
                            FROM users u
                            JOIN chat_user cu ON u.id = cu.user_id
                            WHERE cu.chat_id = chats.id AND u.id != $authUserId
                        )
                        ELSE chats.name
                    END as chat_name
                ")
            )
            ->join('chat_user', 'chats.id', '=', 'chat_user.chat_id')
            ->join('users', 'chat_user.user_id', '=', 'users.id')
            ->where('chat_user.user_id', Auth::id())
            ->groupBy('chats.id', 'chats.name')
            ->orderBy('chats.id', 'DESC')
            ->get();
    }

    public function getChatMembersByChatId(int $id): Collection
    {
        return DB::table('users')
            ->join('chat_user', 'users.id', '=', 'chat_user.user_id')
            ->where('chat_user.chat_id', '=', $id)
            ->select('users.id', 'users.name')
            ->get();
    }

    public function getChatById(int $id): stdClass
    {
        return DB::table('chats')
            ->select(['id', 'name'])
            ->where('chats.id', $id)
            ->first();
    }
}
