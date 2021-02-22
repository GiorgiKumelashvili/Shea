<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Same as items
 * @property mixed id
 * @property mixed name
 * @property mixed index
 * @property mixed color
 *
 * Additions
 * @property mixed location
 * @property mixed items
 */
class CardResource extends JsonResource {

    public function toArray($request): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'location' => $this->location,
            'color' => $this->color,
            'index' => $this->index,
            'child' => ItemResource::collection($this->items)
        ];
    }
}
