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



Route::post('/t', [CardController::class, 'getAll']);
Route::post('/updateCardIndex', [CardController::class, 'updateCardIndex']);

Route::post('/updateItemIndexOnDragAdd', [ItemController::class, 'updateItemIndexOnDragAdd']);
Route::post('/updateItemIndexOnDragRemove', [ItemController::class, 'updateItemIndexOnDragRemove']);
Route::post('/updateIndexOnInsideDragUpdate', [ItemController::class, 'updateIndexOnInsideDragUpdate']);

// testings
Route::get('/test', [CardController::class, 'test']);
