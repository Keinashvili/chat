<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use stdClass;

/**
 * @property-read stdClass $resource
 */
class ChatResource extends JsonResource
{
    public function __construct(
        private readonly stdClass|Chat $chat,
        private readonly ?Collection $users = null
    ) {
        parent::__construct(null);
    }

    public function toArray(Request $request): array
    {
        return [
            $this->merge(ChatBaseResource::make($this->chat)),
            'name' => $this->chat->name ?? $this->users?->firstWhere('id', '!=', $request->user()->getKey())->name,
            'users' => $this->when((bool) $this->users, $this->users),
        ];
    }
}
