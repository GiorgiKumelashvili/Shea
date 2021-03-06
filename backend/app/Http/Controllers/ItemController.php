<?php
/** @noinspection PhpUndefinedFieldInspection */

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Mime\Encoder\Rfc2231Encoder;

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

    public function updateItem(Request $request): JsonResponse {
        $request->validate([
            'id' => 'required',
            'url' => 'nullable',
            'name' => 'nullable'
        ]);

        if (isset($request->url)) {
            Item::where('id', $request->id)->update([
                'url' => $request->url
            ]);
        }

        if (isset($request->name)) {
            Item::where('id', $request->id)->update([
                'name' => $request->name
            ]);
        }

        return response()->json([
            'message' => 'Updated item'
        ]);
    }

    public function deleteItem(Request $request): JsonResponse {
        $request->validate([
            'id' => 'required',
            'card_id' => 'required'
        ]);

        // Get item
        $item = Item::where('id', $request->id)->first();

        // Save item index
        $index = $item->index;

        // Delete item
        $item->delete();

        // Decrement indexes
        DB::table(self::DB_NAME)
            ->where('card_id', $request->card_id)
            ->where('index', '>', $index)
            ->decrement('index');

        // return response
        return response()->json([
            'message' => 'Deleted Item'
        ]);
    }

    private function returnResponse(): JsonResponse {
        return response()->json([
            'message' => 'changed position of item indexes'
        ]);
    }
}
