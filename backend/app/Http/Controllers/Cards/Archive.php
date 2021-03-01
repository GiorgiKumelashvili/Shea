<?php

namespace App\Http\Controllers\Cards;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface Archive {
    public function Archive(Request $request): AnonymousResourceCollection;
}
