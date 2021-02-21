<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CardResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'location' => $this->location,
            'color' => $this->color,
            'child' => ItemResource::collection($this->items)
//            'items' => ItemResource::collection($this->items)
        ];
    }
}
