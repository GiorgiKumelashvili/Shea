<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function updateItemIndexOnAdd(Request $request) {
        $data = $request->validate([
            'newIndex' => 'required',
            'cardId' => 'required'
        ]);
    }

    public function updateItemIndexOnRemove(Request $request) {
        $data = $request->validate([
            'oldIndex' => 'required',
            'cardId' => 'required'
        ]);
    }
}
