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
            'oldIndex' => 'required',
            'newIndex' => 'required',
            'card' => 'required'
        ]);

        $cardId = $data['card']['id'];
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
}
