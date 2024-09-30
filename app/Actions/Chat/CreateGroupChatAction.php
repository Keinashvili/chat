<?php

declare(strict_types=1);

namespace App\Actions\Chat;

use App\Enums\ChatTypeEnum;
use App\Http\Requests\Chat\CreateGroupChatRequest;
use App\Models\Chat;
use App\Services\ChatService;
use Exception;
use Illuminate\Support\Facades\DB;

readonly class CreateGroupChatAction
{
    public function __construct(private ChatService $chatService)
    {
    }

    /**
     * @throws Exception
     */
    public function execute(CreateGroupChatRequest $request): Chat
    {
        try {
            DB::beginTransaction();

            $chat = new Chat();

            $chat->name = $request->name ?? $this->chatService->getChatName($request->user_ids);
            $chat->type = ChatTypeEnum::GROUP->value;
            $chat->save();

            $chat->user()->attach($request->user_ids);

            DB::commit();

            return $chat;
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }
    }
}
