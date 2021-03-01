<?php
/** @noinspection PhpMissingFieldTypeInspection */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

/**
 * @method static where(string $string, mixed $cardId)
 * @method static create(array $data)
 */
class Item extends Model {
    use HasFactory;

    protected $guarded = [];

    public function card(): BelongsTo {
        return $this->belongsTo(Card::class);
    }

    public static function deleteAll(int $cardId): void {
        DB::table('items')
            ->where('card_id', $cardId)
            ->delete();
    }
}
