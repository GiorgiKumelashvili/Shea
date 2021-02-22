<?php

namespace App\Http\Controllers;

use App\Http\Resources\CardResource;
use App\Models\Card;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class CardController extends Controller {
    public function getAll(): AnonymousResourceCollection {
        // return CardResource::collection(Card::with('items')->get());

        // Ordered by index in cards and items
        return CardResource::collection(Card::with(['items' => fn($q) => $q->orderBy('index')])
            ->orderBy('index')
            ->get());
    }

    public function test(): AnonymousResourceCollection {
        return $this->getAll();
    }

    public function t(Request $request) {
        $data = $request->validate([
            'oldIndex' => 'required', // 2
            'newIndex' => 'required', // 1
            'card' => 'required'
        ]);

        $cardId = $data['card']['id'];
        $newIndex = $data['newIndex'];
        $oldIndex = $data['oldIndex'];

        // Increment goes from left to right -->
        if ($oldIndex > $newIndex) {

//            Card::where('id', $cardId)->update(['index' => $newIndex]);
//
//            DB::table('cards')
//                ->where('id', '!=', $cardId)
//                ->where('index', '>=', $newIndex)
//                ->where('index', '<', $oldIndex)
//                ->increment('index');

            Card::where('id', $cardId)->update(['index' => $newIndex]);

            DB::table('cards')
                ->where('index', '>=', $newIndex)
                ->where('index', '<', $oldIndex)
                ->increment('index');

        }
        // Decrement goes from right to left <--
        else {
            Card::where('id', $cardId)->update(['index' => $newIndex]);

            DB::table('cards')
                ->where('id', '!=', $cardId)
                ->where('index', '<=', $newIndex)
                ->where('index', '>', $oldIndex)
                ->decrement('index');
        }

        return response()->json(['message' => 'changed position of card and indexes']);
    }
}
