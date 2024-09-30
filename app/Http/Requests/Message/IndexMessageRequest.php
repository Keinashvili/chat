<?php

declare(strict_types=1);

namespace App\Http\Requests\Message;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read int $chat_id
*/
class IndexMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
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
            'chat_id' => (int) $this->route('chat_id'),
        ]);
    }
}
