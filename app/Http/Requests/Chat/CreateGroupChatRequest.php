<?php

declare(strict_types=1);

namespace App\Http\Requests\Chat;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property-read string $name
 * @property-read mixed $user_ids
*/
class CreateGroupChatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'nullable',
                'string',
                'max:255',
            ],
            'user_ids' => [
                'required',
                'array',
                'min:2',
            ],
            'user_ids.*' => [
                Rule::exists('users', 'id'),
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'user_ids' => array_merge([$this->user()->id], $this->user_ids),
        ]);
    }
}
