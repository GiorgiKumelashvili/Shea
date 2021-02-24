<?php
/** @noinspection PhpMissingFieldTypeInspection */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static where(string $string, mixed $oldIndex)
 * @method static create(array $array)
 * @method static find(string $string, mixed $id)
 */
class Card extends Model {
    use HasFactory;
    protected $guarded = [];

    public function items(): HasMany {
        return $this->hasMany(Item::class);
    }
}
