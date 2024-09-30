<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Chat\CreateChatAction;
use App\Actions\Chat\DeleteChatAction;
use App\Actions\Chat\UpdateChatAction;
use App\Actions\Message\Dtos\UpdateChatActionDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\CreateChatRequest;
use App\Http\Requests\Chat\DeleteChatRequest;
use App\Http\Requests\Chat\ShowChatRequest;
use App\Http\Requests\Chat\UpdateChatRequest;
use App\Http\Resources\ChatBaseResource;
use App\Http\Resources\ChatIndexResource;
use App\Http\Resources\ChatResource;
use App\Repositories\Contracts\ChatRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ChatController extends Controller
{
    public function __construct(private readonly ChatRepositoryInterface $chatRepository)
    {
    }

    /**
     * @OA\Get(
     *     path="/api/chats",
     *     tags={"Chats"},
     *     summary="Fetch all chats for the authenticated user",
     *     @OA\Response(
     *         response=200,
     *         description="A list of chats",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 oneOf={
     *                     @OA\Schema(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="name", type="string", example="Group Chat")
     *                     ),
     *                     @OA\Schema(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=2),
     *                         @OA\Property(property="name", type="string", example="Private Chat")
     *                     )
     *                 }
     *             )
     *         )
     *     )
     * )
     */
    public function index(): AnonymousResourceCollection
    {
        return ChatIndexResource::collection(
            $this->chatRepository->getAll(),
        );
    }

    /**
     * @OA\Post(
     *     path="/api/chats",
     *     tags={"Chats"},
     *     summary="Create a new private chat",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"recipient_id"},
     *             @OA\Property(property="recipient_id", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Chat created",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="recipient_id", type="integer", example=2),
     *             @OA\Property(property="name", type="string", example="Chat name")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     * @throws Exception
     */
    public function store(CreateChatRequest $request, CreateChatAction $action): ChatBaseResource
    {
        return ChatBaseResource::make($action->execute($request));
    }

    /**
     * @OA\Get(
     *     path="/api/chats/{chat_id}",
     *     tags={"Chats"},
     *     summary="Get chat details",
     *     description="Retrieve details of a specific chat including recipient ID and chat metadata.",
     *     @OA\Parameter(
     *         name="chat_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Chat details",
     *         @OA\JsonContent(
     *             @OA\Property(property="chat_id", type="integer", example=1),
     *             @OA\Property(property="recipient_id", type="integer", example=2),
     *             @OA\Property(property="name", type="string", example="Chat with John Doe")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Chat not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function show(ShowChatRequest $request): ChatResource
    {
        return ChatResource::make(
            $this->chatRepository->getChatById($request->chat_id),
            $this->chatRepository->getChatMembersByChatId($request->chat_id)
        );
    }

    /**
     * @OA\Patch(
     *     path="/api/chats/{chat_id}",
     *     tags={"Chats"},
     *     summary="Update chat details",
     *     @OA\Parameter(
     *         name="chat_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", maxLength=255, example="Updated Chat Name")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Chat updated",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Updated Chat Name")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Chat not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(UpdateChatRequest $request, UpdateChatAction $action): ChatResource
    {
        $action->execute(
            new UpdateChatActionDTO(
                chat: $request->chat,
                name: $request->name
            )
        );

        return ChatResource::make($request->chat);
    }

    /**
     * @OA\Delete(
     *     path="/api/chats/{chat_id}",
     *     tags={"Chats"},
     *     summary="Delete a chat",
     *     @OA\Parameter(
     *         name="chat_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Chat deleted",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Chat deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Chat not found"
     *     )
     * )
     * @throws Exception
     */
    public function destroy(DeleteChatRequest $request, DeleteChatAction $action): JsonResponse
    {
        $action->execute($request);

        return response()->json(['message' => 'Chat deleted successfully']);
    }
}
