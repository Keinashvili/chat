<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use stdClass;

/**
 * @property-read stdClass $resource
 */
class ChatIndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            $this->merge(ChatBaseResource::make($this->resource)),
            'name' => $this->resource->chat_name,
        ];
    }
}
