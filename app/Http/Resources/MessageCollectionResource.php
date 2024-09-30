<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read CursorPaginator $resource
 */
class MessageCollectionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'data' => MessageResource::collection($this->resource->items()),
            'next_cursor' => $this->resource->nextCursor()?->encode(),
        ];
    }
}
