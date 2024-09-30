<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Chat\AddMemberToChatAction;
use App\Actions\Chat\Dtos\ChatMembersActionDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\AddChatMemberRequest;
use App\Http\Resources\ChatResource;
use App\Repositories\Contracts\ChatRepositoryInterface;
use Exception;

class AddMemberToChatController extends Controller
{
    public function __construct(private readonly ChatRepositoryInterface $chatRepository)
    {
    }

    /**
     * @OA\Post(
     *     path="/api/chats/{chat_id}/add-members",
     *     tags={"Chats"},
     *     summary="Add members to a chat",
     *     description="Add members to a specified chat and return updated chat details with users.",
     *     @OA\Parameter(
     *         name="chat_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_ids"},
     *             @OA\Property(
     *                 property="user_ids",
     *                 type="array",
     *                 @OA\Items(type="integer", example=2),
     *                 example={2, 3}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Members added to chat",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Renamed chat"),
     *             @OA\Property(
     *                 property="users",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=6),
     *                     @OA\Property(property="name", type="string", example="John Doe")
     *                 ),
     *                 example={
     *                     {"id": 1, "name": "John Doe"},
     *                     {"id": 2, "name": "Prof. Estevan Hill II"}
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Chat or user not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     * @throws Exception
     */
    public function __invoke(AddChatMemberRequest $request, AddMemberToChatAction $action): ChatResource
    {
        $action->execute(
            new ChatMembersActionDTO(
                chat: $request->chat,
                userIds: $request->user_ids
            )
        );

        return ChatResource::make(
            $request->chat,
            $this->chatRepository->getChatMembersByChatId($request->chat_id)
        );
    }
}
