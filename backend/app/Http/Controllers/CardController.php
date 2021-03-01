<?php
/** @noinspection PhpUndefinedFieldInspection */

namespace App\Http\Controllers;

use App\Http\Controllers\Cards\Archive;
use App\Http\Resources\CardResource;
use App\Models\Card;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

// interfaces
use App\Http\Controllers\Cards\Stash;

class CardController extends Controller implements Stash, Archive {
    public const DB_NAME = "cards";
    public const STASH_LOCATION = 1;
    public const ARCHIVE_LOCATION = 2;

    /*
     * Stash Methods
     */

    public function Stash(Request $request): AnonymousResourceCollection {
        $request->validate([
            'user_id' => 'required'
        ]);

        // Ordered by index in cards and items
        return CardResource::collection(Card::with(['items' => fn($q) => $q->orderBy('index')])
            ->where('user_id', $request->user_id)
            ->where('location', self::STASH_LOCATION)
            ->orderBy('index')
            ->get());
    }

    public function updateCardIndex(Request $request): JsonResponse {
        $data = $request->validate([
            'oldIndex' => 'required',
            'newIndex' => 'required',
            'cardId' => 'required',
            'user_id' => 'required'
        ]);

        $cardId = $data['cardId'];
        $newIndex = $data['newIndex'];
        $oldIndex = $data['oldIndex'];

        if ($oldIndex > $newIndex) {
            // Increment goes from [newIndex, oldIndex)
            DB::table('cards')
                ->where('user_id', $request->user_id)
                ->where('location', self::STASH_LOCATION)
                ->where('index', '>=', $newIndex)
                ->where('index', '<', $oldIndex)
                ->increment('index');

            Card::where('id', $cardId)->update(['index' => $newIndex]);
        }
        else {
            // Decrement goes from (oldIndex, newIndex]
            DB::table('cards')
                ->where('user_id', $request->user_id)
                ->where('location', self::STASH_LOCATION)
                ->where('index', '>', $oldIndex)
                ->where('index', '<=', $newIndex)
                ->decrement('index');

            Card::where('id', $cardId)->update(['index' => $newIndex]);

        }

        return response()->json(['message' => 'changed position of card and indexes']);
    }

    public function addNewCard(Request $request): JsonResponse {
        $data = $request->validate([
            'name' => 'required',
            'location' => 'required',
            'index' => 'required',
            'user_id' => 'required'
        ]);

        Card::create($data);

        return response()->json([
            'message' => 'Card added'
        ]);
    }

    public function deleteCard(Request $request): JsonResponse {
        $request->validate([
            'id' => 'required',
            'location' => 'required',
            'user_id' => 'required'
        ]);

        $location = self::STASH_LOCATION;

        if ($request->location == 2) {
            $location = self::ARCHIVE_LOCATION;
        }


        // First delete items
        DB::table('items')
            ->where('card_id', $request->id)
            ->delete();

        // Get card
        $card = Card::where('id', $request->id)->first();

        // Save card index
        $index = $card->index;

        // Second delete card itself
        $card->delete();

        // Third decrement indexes
        DB::table(self::DB_NAME)
            ->where('user_id', $request->user_id)
            ->where('location', $location)
            ->where('index', '>', $index)
            ->decrement('index');

        return response()->json([
            'message' => 'Card deleted'
        ]);
    }

    public function updateCardName(Request $request): JsonResponse {
        $request->validate([
            'id' => 'required',
            'newName' => 'required'
        ]);

        DB::table(self::DB_NAME)
            ->where('id', $request->id)
            ->update(['name' => $request->newName]);

        return response()->json([
            'message' => 'Card name updated'
        ]);
    }


    public function transferToArchive(Request $request): JsonResponse {
        $request->validate([
            'id' => 'required',
            'user_id' => 'required',
            'index' => 'required'
        ]);

        // Third decrement indexes
        DB::table(self::DB_NAME)
            ->where('user_id', $request->user_id)
            ->where('location', self::STASH_LOCATION)
            ->where('index', '>', $request->index)
            ->decrement('index');

        Card::where('id', $request->id)->update(['location' => self::ARCHIVE_LOCATION]);

        return response()->json([
            'message' => 'Card transfered to Archive'
        ]);
    }

    /*
     * Archive methods
     */

    public function Archive(Request $request): AnonymousResourceCollection {
        $request->validate([
            'user_id' => 'required'
        ]);

        return CardResource::collection(Card::with(['items' => fn($q) => $q->orderBy('index')])
            ->where('user_id', $request->user_id)
            ->where('location', self::ARCHIVE_LOCATION)
            ->orderBy('index')
            ->get());
    }
}
