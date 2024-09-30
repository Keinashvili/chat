<?php

declare(strict_types=1);

namespace App\Actions\Chat;

use App\Http\Requests\Chat\CreateChatRequest;
use App\Models\Chat;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

readonly class CreateChatAction
{
    /**
     * @throws Exception
     */
    public function execute(CreateChatRequest $request): Chat
    {
        try {
            DB::beginTransaction();

            $chat = new Chat();
            $chat->save();

            $chat->user()->attach([
                Auth::id(),
                $request->recipient_id,
            ]);

            DB::commit();

            return $chat;
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }
    }
}
