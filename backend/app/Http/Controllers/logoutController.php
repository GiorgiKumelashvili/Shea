<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class logoutController extends Controller {
    public function logout(Request $request) {
        $request->user()->tokens()->delete();
    }
}
