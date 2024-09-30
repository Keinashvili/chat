<?php

declare(strict_types=1);

namespace App\Actions\Chat;

use App\Actions\Message\Dtos\UpdateChatActionDTO;

class UpdateChatAction
{
    public function execute(UpdateChatActionDTO $dto): void
    {
        $chat = $dto->chat;
        $chat->name = $dto->name;
        $chat->save();
    }
}
