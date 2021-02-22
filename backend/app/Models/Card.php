<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static where(string $string, mixed $oldIndex)
 */
class Card extends Model {
    use HasFactory;

    public function items(): HasMany {
        return $this->hasMany(Item::class);
    }
}
