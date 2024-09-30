<?php

declare(strict_types=1);

namespace App\Actions\Message;

use App\Actions\Message\Dtos\SendMessageActionDTO;
use App\Enums\MessageStatusEnum;
use App\Events\MessageEvent;
use App\Models\Message;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

readonly class SendMessageAction
{
    /**
     * @throws Exception
     */
    public function execute(SendMessageActionDTO $dto): Message
    {
        try {
            DB::beginTransaction();

            $message = $dto
                ->chat
                ->message()
                ->create([
                    'sender_id' => Auth::id(),
                    'message' => $dto->message,
                    'status' => MessageStatusEnum::SENT->value,
            ]);

            event(
                new MessageEvent($message, $dto->sender_name, 'send-message')
            );

            DB::commit();

            return $message;
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }
    }
}
