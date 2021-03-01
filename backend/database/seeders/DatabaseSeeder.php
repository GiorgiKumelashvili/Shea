<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder {

    public function run() {
//         User::factory(10)->create();
//         Card::factory(6)->create();
//         Item::factory(10)->create();
        User::create([
            'name' => 'Guest',
            'email' => 'guest@guest.com',
            'email_verified_at' => now(),
            'password' => Hash::make('guest123'),
            'remember_token' => Str::random(10),
        ]);
    }
}
