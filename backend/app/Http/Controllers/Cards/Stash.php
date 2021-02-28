<?php

namespace App\Http\Controllers\Cards;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface Stash {
    public function Stash(): AnonymousResourceCollection;
    public function updateCardIndex(Request $request): JsonResponse;
    public function addNewCard(Request $request): JsonResponse;
    public function deleteCard(Request $request): JsonResponse;
    public function updateCardName(Request $request): JsonResponse;
}
