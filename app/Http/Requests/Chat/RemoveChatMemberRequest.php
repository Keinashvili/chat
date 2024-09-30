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
class RemoveChatMemberRequest extends FormRequest
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
            ],
            'user_ids' => [
                'required', 'array',
            ],
            'user_ids.*' => [
                Rule::exists('chat_user', 'user_id')->where(function ($query) {
                    $query->where('chat_id', '=', $this->chat_id);
                }),
            ],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'chat_id' => $this->route('chat_id'),
        ]);
    }
}
