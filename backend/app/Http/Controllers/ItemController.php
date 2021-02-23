<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
            'cardId' => 'required'
        ]);
    }
}
