<?php

declare(strict_types=1);

namespace App\Http\Requests\Message;

use App\Models\Message;
use App\Repositories\Contracts\MessageRepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read int $chat_id
 * @property-read int $message_id
*/
class DeleteMessageRequest extends FormRequest
{
    public readonly Message $message;

    public function authorize(): bool
    {
        $this->message = resolve(MessageRepositoryInterface::class)->findById($this->message_id);

        return true;
    }

    public function rules(): array
    {
        return [
            'chat_id' => [
                'required',
                'integer',
            ],
            'message_id' => [
                'required',
                'integer',
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'chat_id' => (int) $this->route('chat_id'),
            'message_id' => (int) $this->route('message_id'),
        ]);
    }
}
