<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Message;
use App\Repositories\Contracts\MessageRepositoryInterface;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Support\Facades\DB;

class MessageRepository implements MessageRepositoryInterface
{
    public function findById(int $id): ?Message
    {
        return Message::query()
            ->findOrFail($id);
    }

    public function getAllByChatId(int $id): CursorPaginator
    {
        return DB::table('messages')
            ->select('messages.id', 'messages.message', 'messages.status', 'users.name as sender_name')
            ->join('users', 'messages.sender_id', '=', 'users.id')
            ->where('messages.chat_id', '=', $id)
            ->orderBy('messages.id', 'DESC')
            ->cursorPaginate(20);
    }
}
