<?php

declare(strict_types=1);

namespace App\Actions\Chat;

use App\Http\Requests\Chat\DeleteChatRequest;
use Exception;
use Illuminate\Support\Facades\DB;

class DeleteChatAction
{
    /**
     * @throws Exception
     */
    public function execute(DeleteChatRequest $request): void
    {
        try {
            DB::beginTransaction();

            $chat = $request->chat;

            $chat->user()->detach();

            $chat->message()->delete();

            $chat->delete();

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }
    }
}
