<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Chat\Dtos\ChatMembersActionDTO;
use App\Actions\Chat\RemoveMemberFromChatAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\RemoveChatMemberRequest;
use App\Http\Resources\ChatResource;

class RemoveMemberFromChatController extends Controller
{
    /**
     * @OA\Delete(
     *     path="/api/chats/{chat_id}/remove-members",
     *     tags={"Chats"},
     *     summary="Remove members from a chat",
     *     description="Remove specified members from a chat.",
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
     *          response=200,
     *          description="Removed member from chat",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="integer", example=1),
     *              @OA\Property(property="name", type="string", example="Renamed chat"),
     *              @OA\Property(
     *                  property="users",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="id", type="integer", example=6),
     *                      @OA\Property(property="name", type="string", example="John Doe")
     *                  ),
     *                  example={
     *                      {"id": 1, "name": "John Doe"}
     *                  }
     *              )
     *          )
     *      ),
     *     @OA\Response(
     *         response=404,
     *         description="Chat or user not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function __invoke(RemoveChatMemberRequest $request, RemoveMemberFromChatAction $action): ChatResource
    {
        $action->execute(
            new ChatMembersActionDTO(
                chat: $request->chat,
                userIds: $request->user_ids
            )
        );

        return ChatResource::make($request->chat);
    }
}
