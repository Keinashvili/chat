<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\DB;

Broadcast::channel('chat.{chatId}', function ($user, $chatId) {
    return DB::table('chat_user')->where('chat_id', $chatId)->where('user_id', $user->id)->exists();
});
