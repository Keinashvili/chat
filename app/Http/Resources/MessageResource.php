<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'message' => $this->resource->message,
            'sender' => $this->resource->sender_name ?? $this->resource->sender->name,
            'status' => $this->resource->status,
        ];
    }
}
