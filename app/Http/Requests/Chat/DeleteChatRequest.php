<?php

declare(strict_types=1);

namespace App\Http\Requests\Chat;

use App\Models\Chat;
use App\Repositories\Contracts\ChatRepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read int $chat_id
*/
class DeleteChatRequest extends FormRequest
{
    public readonly Chat $chat;

    public function authorize(): bool
    {
        $this->chat = resolve(ChatRepositoryInterface::class)->findById($this->chat_id);

        return true;
    }

    public function rules(): array
    {
        return [
            'chat_id' => [
                'required',
                'integer',
            ]
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'chat_id' => $this->route('chat_id'),
        ]);
    }
}
