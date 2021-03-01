<?php
/** @noinspection PhpMissingFieldTypeInspection */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

/**
 * @method static where(string $string, mixed $oldIndex)
 * @method static create(array $array)
 * @method static find(string $string, mixed $id)
 */
class Card extends Model {
    use HasFactory;

    protected $guarded = [];
    public const DB_NAME = 'cards';

    public function items(): HasMany {
        return $this->hasMany(Item::class);
    }

    public static function retrieveDeletedIndex(int $cardId): int {
        // Get card
        $card = Card::where('id', $cardId)->first();

        // Save card index
        $index = $card->index;

        // Delete card itself
        $card->delete();

        return $index;
    }

    public static function updateIndex(int $id, int $newIndex): void {
        self::where('id', $id)->update(['index' => $newIndex]);
    }

    public static function updateIndexes(int $oldIndex, int $newIndex, int $id, int $location) {
        if ($oldIndex > $newIndex) {
            // Increment goes from [newIndex, oldIndex)
            DB::table('cards')
                ->where('user_id', $id)
                ->where('location', $location)
                ->where('index', '>=', $newIndex)
                ->where('index', '<', $oldIndex)
                ->increment('index');

        }
        else {
            // Decrement goes from (oldIndex, newIndex]
            DB::table('cards')
                ->where('user_id', $id)
                ->where('location', $location)
                ->where('index', '>', $oldIndex)
                ->where('index', '<=', $newIndex)
                ->decrement('index');
        }
    }

    public static function updateColumn(int $id, string $columnName, $newValue): void {
        DB::table(self::DB_NAME)
            ->where('id', $id)
            ->update([$columnName => $newValue]);
    }

    public static function decrementIndexesToRight(int $userId, int $location, int $index): void {
        DB::table(self::DB_NAME)
            ->where('user_id', $userId)
            ->where('location', $location)
            ->where('index', '>', $index)
            ->decrement('index');
    }
}
