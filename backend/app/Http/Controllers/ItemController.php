<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller {
    public const DB_NAME = "items";
    public const CARD_ID_COLUMN = "card_id";

    public function updateItemIndexOnDragAdd(Request $request): JsonResponse {
        $data = $request->validate([
            'newIndex' => 'required',
            'cardId' => 'required',
            'itemId' => 'required'
        ]);

        $cardId = $data['cardId'];
        $newIndex = $data['newIndex'];

        DB::table(self::DB_NAME)
            ->where(self::CARD_ID_COLUMN, $cardId)
            ->where('index', '>=', $newIndex)
            ->increment('index');

        Item::where('id', $data['itemId'])->update([
            'index' => $newIndex,
            self::CARD_ID_COLUMN => $cardId
        ]);

        return $this->returnResponse();
    }

    public function updateItemIndexOnDragRemove(Request $request): JsonResponse {
        $data = $request->validate([
            'oldIndex' => 'required',
            'cardId' => 'required'
        ]);

        DB::table(self::DB_NAME)
            ->where(self::CARD_ID_COLUMN, $data['cardId'])
            ->where('index', '>', $data['oldIndex'])
            ->decrement('index');

        return $this->returnResponse();
    }

    public function updateIndexOnInsideDragUpdate(Request $request): JsonResponse {
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
            DB::table(self::DB_NAME)
                ->where(self::CARD_ID_COLUMN, $cardId)
                ->where('index', '>=', $newIndex)
                ->where('index', '<', $oldIndex)
                ->increment('index');
        }
        else {
            // Decrement goes from (oldIndex, newIndex]
            DB::table(self::DB_NAME)
                ->where(self::CARD_ID_COLUMN, $cardId)
                ->where('index', '>', $oldIndex)
                ->where('index', '<=', $newIndex)
                ->decrement('index');
        }

        Item::where('id', $data['itemId'])->update(['index' => $newIndex]);

        return $this->returnResponse();
    }

    public function addNewItem(Request $request): JsonResponse {
        $data = $request->validate([
            'name' => 'required',
            'card_id' => 'required',
            'url' => 'required',
            'index' => 'required',
            'description' => 'nullable'
        ]);

        Item::create($data);

        return response()->json([
            'message' => 'Added new item'
        ]);
    }

    private function returnResponse(): JsonResponse {
        return response()->json([
            'message' => 'changed position of item indexes'
        ]);
    }
}
