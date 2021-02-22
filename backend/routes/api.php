<?php
/** @noinspection PhpUndefinedFieldInspection */

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

Route::post('/t', [\App\Http\Controllers\CardController::class, 'getAll']);

// testings
Route::get('/test', [\App\Http\Controllers\CardController::class, 'test']);
Route::post('/updateCardIndex', [\App\Http\Controllers\CardController::class, 't']);

