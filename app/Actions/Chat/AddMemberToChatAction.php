<?php

declare(strict_types=1);

namespace App\Actions\Chat;

use App\Actions\Chat\Dtos\ChatMembersActionDTO;
use App\Enums\ChatTypeEnum;
use App\Services\ChatMemberService;
use App\Services\ChatService;
use Exception;
use Illuminate\Support\Facades\DB;

readonly class AddMemberToChatAction
{
    public function __construct(
        private ChatService $chatService,
        private ChatMemberService $chatMemberService,
    ){

    }

    /**
     * @throws Exception
     */
    public function execute(ChatMembersActionDTO $dto): int
    {
        try {
            DB::beginTransaction();

            $chat = $dto->chat;

            $existingMembers = DB::table('chat_user')
                ->where('chat_id', '=', $chat->id)
                ->pluck('user_id')
                ->toArray();

            $memberIds = array_unique(array_merge($existingMembers, $dto->userIds));

            $chatName = $this->chatService->getChatName($memberIds);

            if (DB::table('chats')->where('id', '=', $chat->id)->value('type') === ChatTypeEnum::PRIVATE->value) {
                $chat = $this->chatService->createGroupChat($chatName);
            }

            $this->chatMemberService->addMemberToChat($chat, $memberIds);

            DB::commit();

            return $chat->id;
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }
    }
}
