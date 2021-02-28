<?php

namespace App\Http\Controllers\Cards;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface Archive {
    public function Archive(): AnonymousResourceCollection;
}
