<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Chat\CreateGroupChatAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\CreateGroupChatRequest;
use App\Http\Resources\ChatResource;
use Exception;

class StoreGroupChatController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/chats/group",
     *     tags={"Chats"},
     *     summary="Create a new group chat",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Project Discussion"),
     *             @OA\Property(property="user_ids", type="array", @OA\Items(type="integer", example=3)),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Group chat created",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Project Discussion")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     * @throws Exception
     */
    public function __invoke(CreateGroupChatRequest $request, CreateGroupChatAction $action): ChatResource
    {
        return ChatResource::make($action->execute($request));
    }
}
