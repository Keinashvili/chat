<?php

declare(strict_types=1);

namespace App\Actions\Message;

use App\Actions\Message\Dtos\DeleteMessageActionDTO;
use App\Enums\MessageStatusEnum;
use App\Events\MessageEvent;
use Exception;

readonly class DeleteMessageAction
{
    /**
     * @throws Exception
     */
    public function execute(DeleteMessageActionDTO $dto): void
    {
        $message = $dto->message;

        $message->update([
            'message' => 'This message has been deleted.',
            'status' => MessageStatusEnum::DELETED->value,
        ]);

        event(
            new MessageEvent($dto->message, $dto->sender_name, 'message-deleted')
        );
    }
}
