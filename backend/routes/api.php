<?php
/** @noinspection PhpUndefinedFieldInspection */

use App\Http\Controllers\CardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\logoutController;
use App\Http\Controllers\TokenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group.
|
*/

// Protected by token
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [logoutController::class, 'logout']);

});

Route::post('/tokens/create', [TokenController::class, 'createToken']);


// Card Stash Methods
Route::post('/card/stash', [CardController::class, 'Stash']);
Route::post('/card/stash/update-card-index', [CardController::class, 'updateCardIndex']);
Route::post('/card/stash/add-card', [CardController::class, 'addNewCard']);
Route::post('/card/stash/delete-card', [CardController::class, 'deleteCard']);
Route::post('/card/stash/update-card-name', [CardController::class, 'updateCardName']);

//!!!!!
Route::post('/card/move-card-to-archive', [CardController::class, 'transferToArchive']);

// Card Archive Methods
Route::post('/card/archive', [CardController::class, 'Archive']);

// Item methods
Route::post('/item/add', [ItemController::class, 'addNewItem']);
Route::post('/item/delete', [ItemController::class, 'deleteItem']);
Route::post('/item/update', [ItemController::class, 'updateItem']);

Route::post('/item/update-item-index-on-drag-add', [ItemController::class, 'updateItemIndexOnDragAdd']);
Route::post('/item/update-item-index-on-drag-remove', [ItemController::class, 'updateItemIndexOnDragRemove']);
Route::post('/item/update-item-index-on-inside-drag', [ItemController::class, 'updateIndexOnInsideDragUpdate']);
