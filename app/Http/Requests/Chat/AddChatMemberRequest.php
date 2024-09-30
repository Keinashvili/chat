<?php

declare(strict_types=1);

namespace App\Http\Requests\Chat;

use App\Models\Chat;
use App\Repositories\Contracts\ChatRepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property-read int $chat_id
 * @property-read array $user_ids
*/
class AddChatMemberRequest extends FormRequest
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
            'user_ids' => [
                'required',
                'array',
            ],
            'user_ids.*' => [
                Rule::exists('users', 'id'),
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'chat_id' => (int) $this->route('chat_id'),
        ]);
    }
}
