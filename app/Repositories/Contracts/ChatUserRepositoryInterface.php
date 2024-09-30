<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

interface ChatUserRepositoryInterface
{
    public function getByUserAndChatId(int $userId, int $chatId);
}
