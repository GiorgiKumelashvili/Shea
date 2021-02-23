<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static where(string $string, mixed $cardId)
 */
class Item extends Model {
    use HasFactory;

    public function card(): BelongsTo {
        return $this->belongsTo(Card::class);
    }
}
