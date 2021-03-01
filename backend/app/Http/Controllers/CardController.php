<?php
/** @noinspection PhpUndefinedFieldInspection */

namespace App\Http\Controllers;

use App\Http\Controllers\Cards\Archive;
use App\Http\Resources\CardResource;
use App\Models\Card;
use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

// interfaces
use App\Http\Controllers\Cards\Stash;

class CardController extends Controller implements Stash, Archive {
    public const STASH_LOCATION = 1;
    public const ARCHIVE_LOCATION = 2;

    /*
     * Stash Methods
     */

    public function Stash(Request $request): AnonymousResourceCollection {
        // Validate
        $this->validated($request, ['user_id']);

        // Retrieve data
        return $this->retriveData($request->user_id, self::STASH_LOCATION);
    }

    public function updateCardIndex(Request $request): JsonResponse {
        // Validate
        $this->validated($request, ['oldIndex', 'newIndex', 'cardId', 'user_id']);

        // Update indexes
        Card::updateIndexes(
            $request->oldIndex,
            $request->newIndex,
            $request->user_id,
            self::STASH_LOCATION
        );

        // Update index at last
        Card::updateIndex($request->cardId, $request->newIndex);

        // Send response
        return $this->send('changed position of card and indexes');
    }

    public function addNewCard(Request $request): JsonResponse {
        // Validate
        $data = $this->validated($request, ['name', 'location', 'index', 'user_id']);

        // Create
        Card::create($data);

        // Response
        return $this->send('Card added');
    }

    public function deleteCard(Request $request): JsonResponse {
        // Validate
        $this->validated($request, ['id', 'location', 'user_id']);

        // Get location
        $location = $request->location == 2 ? self::ARCHIVE_LOCATION : self::STASH_LOCATION;

        // Delete items
        Item::deleteAll($request->id);

        // Get deleted index
        $index = Card::retrieveDeletedIndex($request->id);

        // Decrement indexes
        Card::decrementIndexesToRight($request->user_id, $location, $index);

        // Response
        return $this->send('Card deleted');
    }

    public function updateCardName(Request $request): JsonResponse {
        // Validate
        $this->validated($request, ['id', 'newName']);

        // Update name
        Card::updateColumn($request->id, 'name', $request->newName);

        // Response
        return $this->send('Card name updated');
    }

    public function transferToArchive(Request $request): JsonResponse {
        // Validate
        $this->validated($request, ['id', 'user_id', 'index']);

        // Decrement indexes
        Card::decrementIndexesToRight($request->user_id, self::STASH_LOCATION, $request->index);

        // Update location
        Card::updateColumn($request->id, 'location', self::ARCHIVE_LOCATION);

        // Response
        return $this->send('Card transfered to Archive');
    }

    /*
     * Archive methods
     */

    public function Archive(Request $request): AnonymousResourceCollection {
        // Validate
        $this->validated($request, ['user_id']);

        // Retrieve data
        return $this->retriveData($request->user_id, self::ARCHIVE_LOCATION);
    }

    /*
     * Solid methods
     */
    private function retriveData(int $id, int $location): AnonymousResourceCollection {
        // Ordered by index in cards and items
        return CardResource::collection(Card::with(['items' => fn($q) => $q->orderBy('index')])
            ->where('user_id', $id)
            ->where('location', $location)
            ->orderBy('index')
            ->get());
    }

    private function validated(Request $request, array $array): array {
        return $request->validate(array_fill_keys($array, 'required'));
    }

    private function send(string $message): JsonResponse {
        return response()->json(['message' => $message]);
    }
}
