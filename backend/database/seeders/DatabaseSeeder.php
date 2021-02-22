<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    public function run() {
//         User::factory(10)->create();
//         Card::factory(3)->create();
         Item::factory(8)->create();
    }
}
