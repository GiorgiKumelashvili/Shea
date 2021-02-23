<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller {
    public function updateItemIndexOnDragAdd(Request $request) {
        $data = $request->validate([
            'newIndex' => 'required',
            'cardId' => 'required'
        ]);
    }

    public function updateItemIndexOnDragRemove(Request $request) {
        $data = $request->validate([
            'oldIndex' => 'required',
            'cardId' => 'required'
        ]);
    }

    public function updateIndexOnInsideDragUpdate(Request $request) {
        $data = $request->validate([
            'newIndex' => 'required',
            'oldIndex' => 'required',
            'cardId' => 'required',
            'itemId' => 'required'
        ]);

        $cardId = $data['cardId'];
        $newIndex = $data['newIndex'];
        $oldIndex = $data['oldIndex'];

        if ($oldIndex > $newIndex) {
            // Increment goes from [newIndex, oldIndex)
            DB::table(Item::DB_NAME)
                ->where('card_id', $cardId)
                ->where('index', '>=', $newIndex)
                ->where('index', '<', $oldIndex)
                ->increment('index');
        }
        else {
            // Decrement goes from (oldIndex, newIndex]
            DB::table(Item::DB_NAME)
                ->where('card_id', $cardId)
                ->where('index', '>', $oldIndex)
                ->where('index', '<=', $newIndex)
                ->decrement('index');
        }

        Item::where('id', $data['itemId'])->update(['index' => $newIndex]);

        return response()->json([
            'message' => 'changed position of card and indexes'
        ]);
    }
}
