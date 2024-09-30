<?php

declare(strict_types=1);

namespace App\Actions\Message;

use App\Actions\Message\Dtos\UpdateMessageActionDTO;
use App\Enums\MessageStatusEnum;
use App\Events\MessageEvent;
use App\Models\Message;
use Exception;

readonly class MessageUpdateAction
{
    /**
     * @throws Exception
     */
    public function execute(UpdateMessageActionDTO $dto): Message
    {
        $message = $dto->message;

        $message->update([
            'message' => $dto->message_text,
            'status' => MessageStatusEnum::EDITED->value,
        ]);

        event(
            new MessageEvent($message, $dto->sender_name, 'message-sent')
        );

        return $message;
    }
}
