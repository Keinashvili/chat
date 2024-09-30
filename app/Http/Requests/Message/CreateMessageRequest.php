<?php

declare(strict_types=1);

namespace App\Http\Requests\Message;

use App\Models\Chat;
use App\Repositories\Contracts\ChatRepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read int $chat_id
 * @property-read string $message
*/
class CreateMessageRequest extends FormRequest
{
    public readonly Chat $chat;

    public function authorize(): bool
    {
        $this->chat = resolve(ChatRepositoryInterface::class)->findOrFail($this->chat_id);

        return true;
    }

    public function rules(): array
    {
        return [
            'chat_id' => [
                'required',
                'integer',
            ],
            'message' => [
                'required',
                'string',
            ],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'chat_id' => (int) $this->route('chat_id'),
        ]);
    }
}
