<?php
/** @noinspection PhpUndefinedFieldInspection */

namespace App\Http\Controllers;

use App\Http\Resources\CardResource;
use App\Models\Card;

use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class CardController extends Controller {
    public const DB_NAME = "cards";
    public const STASH_LOCATION = 1;
    public const ARCHIVE_LOCATION = 2;

    public function Stash(): AnonymousResourceCollection {
        // Ordered by index in cards and items
        return CardResource::collection(Card::with(['items' => fn($q) => $q->orderBy('index')])
            ->where('location', self::STASH_LOCATION)
            ->orderBy('index')
            ->get());
    }

    public function Archive(): AnonymousResourceCollection {
        return CardResource::collection(Card::with(['items' => fn($q) => $q->orderBy('index')])
            ->where('location', self::ARCHIVE_LOCATION)
            ->orderBy('index')
            ->get());
    }

    public function updateCardIndex(Request $request): JsonResponse {
        $data = $request->validate([
            'oldIndex' => 'required',
            'newIndex' => 'required',
            'cardId' => 'required'
        ]);

        $cardId = $data['cardId'];
        $newIndex = $data['newIndex'];
        $oldIndex = $data['oldIndex'];

        if ($oldIndex > $newIndex) {
            // Increment goes from [newIndex, oldIndex)
            DB::table('cards')
                ->where('index', '>=', $newIndex)
                ->where('index', '<', $oldIndex)
                ->increment('index');

            Card::where('id', $cardId)->update(['index' => $newIndex]);
        }
        else {
            // Decrement goes from (oldIndex, newIndex]
            DB::table('cards')
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
        ]);

        Card::create($data);

        return response()->json([
            'message' => 'Card added'
        ]);
    }

    public function deleteCard(Request $request): JsonResponse {
        $request->validate([
            'id' => 'required'
        ]);

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
}
