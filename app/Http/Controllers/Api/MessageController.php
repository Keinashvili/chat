<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Message\DeleteMessageAction;
use App\Actions\Message\Dtos\DeleteMessageActionDTO;
use App\Actions\Message\Dtos\SendMessageActionDTO;
use App\Actions\Message\Dtos\UpdateMessageActionDTO;
use App\Actions\Message\MessageUpdateAction;
use App\Actions\Message\SendMessageAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Message\CreateMessageRequest;
use App\Http\Requests\Message\DeleteMessageRequest;
use App\Http\Requests\Message\IndexMessageRequest;
use App\Http\Requests\Message\UpdateMessageRequest;
use App\Http\Resources\MessageCollectionResource;
use App\Http\Resources\MessageResource;
use App\Repositories\Contracts\MessageRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Exception;

class MessageController extends Controller
{
    public function __construct(
        private readonly MessageRepositoryInterface $messageRepository,
        private readonly UserRepositoryInterface $userRepository,
    )
    {
    }

    /**
     * @OA\Get(
     *     path="/api/chats/{chat_id}/messages",
     *     tags={"Messages"},
     *     summary="Retrieve messages for a chat",
     *     description="Fetch all messages associated with a specific chat.",
     *     @OA\Parameter(
     *         name="chat_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Messages retrieved successfully",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="message", type="string", example="Hello World!"),
     *                 @OA\Property(property="sender", type="string", example="John Doe"),
     *                 @OA\Property(property="status", type="string", example="sent")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Chat not found"
     *     )
     * )
     */
    public function index(IndexMessageRequest $request): MessageCollectionResource
    {
        return MessageCollectionResource::make(
            $this->messageRepository->getAllByChatId($request->chat_id)
        );
    }

    /**
     * @OA\Post(
     *     path="/api/chats/{chat_id}/messages",
     *     tags={"Messages"},
     *     summary="Send a message in a chat",
     *     description="Create a new message in a specific chat.",
     *     @OA\Parameter(
     *         name="chat_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"message"},
     *             @OA\Property(property="message", type="string", example="Hello, how are you?")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Message created successfully",
     *         @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  type="object",
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="message", type="string", example="Hello World!"),
     *                  @OA\Property(property="sender", type="string", example="John Doe"),
     *                  @OA\Property(property="status", type="string", example="sent")
     *              )
     *          )
     *      ),
     *     @OA\Response(
     *         response=404,
     *         description="Chat not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     * @throws Exception
     */
    public function store(CreateMessageRequest $request, SendMessageAction $action): MessageResource
    {
        return MessageResource::make(
            $action->execute(
                new SendMessageActionDTO(
                    chat: $request->chat,
                    message: $request->message,
                    sender_name: $this->userRepository->getUserById($request->user()->getKey())->name,
                )
            )
        );
    }

    /**
     * @OA\Patch(
     *     path="/api/chats/{chat_id}/messages/{message_id}",
     *     tags={"Messages"},
     *     summary="Update a message in a chat",
     *     description="Modify an existing message in a specific chat.",
     *     @OA\Parameter(
     *         name="chat_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="message_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"message_text"},
     *             @OA\Property(property="message_text", type="string", example="Hello World! (Edited)")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Message updated successfully",
     *         @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  type="object",
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="message", type="string", example="Hello World! (Edited)"),
     *                  @OA\Property(property="sender", type="string", example="John Doe"),
     *                  @OA\Property(property="status", type="string", example="edited")
     *              )
     *          )
     *      ),
     *     @OA\Response(
     *         response=404,
     *         description="Chat or message not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     * @throws Exception
     */
    public function update(UpdateMessageRequest $request, MessageUpdateAction $action): MessageResource
    {
        $action->execute(
            new UpdateMessageActionDTO(
                message: $request->message,
                message_text: $request->message_text,
                sender_name: $this->userRepository->getUserById($request->user()->getKey())->name,
            )
        );

        return MessageResource::make($request->message);
    }

    /**
     * @OA\Delete(
     *     path="/api/chats/{chat_id}/messages/{message_id}",
     *     tags={"Messages"},
     *     summary="Delete a message from a chat",
     *     description="Remove a specific message from a chat.",
     *     @OA\Parameter(
     *         name="chat_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="message_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Message deleted successfully",
     *          @OA\JsonContent(
     *               type="array",
     *               @OA\Items(
     *                   type="object",
     *                   @OA\Property(property="id", type="integer", example=1),
     *                   @OA\Property(property="message", type="string", example="This message has been deleted."),
     *                   @OA\Property(property="sender", type="string", example="John Doe"),
     *                   @OA\Property(property="status", type="string", example="deleted")
     *               )
     *           )
     *       ),
     *     @OA\Response(
     *         response=404,
     *         description="Chat or message not found"
     *     )
     * )
     * @throws Exception
     */
    public function destroy(DeleteMessageRequest $request, DeleteMessageAction $action): MessageResource
    {
        $action->execute(
            new DeleteMessageActionDTO(
                message: $request->message,
                sender_name: $request->message->sender()->value('name'),
            )
        );

        return MessageResource::make($request->message);
    }
}
