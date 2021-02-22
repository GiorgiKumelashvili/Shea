<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Same as cards
 * @property mixed id
 * @property mixed name
 * @property mixed index
 * @property mixed color
 *
 * Additions
 * @property mixed description
 * @property mixed url
 */
class ItemResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'color' => $this->color,
            'url' => $this->url,
            'index' => $this->index
        ];
    }
}
