<?php /** @noinspection PhpMissingFieldTypeInspection */

namespace Database\Factories;

use App\Models\Card;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ItemFactory extends Factory {
    protected $model = Item::class;

    public function definition(): array {
        return [
            'name' => $this->faker->name,
            'url' => $this->faker->url,
            'color' => $this->faker->hexColor,
            'description' => $this->faker->randomElement([Str::random('100'), null]),
            'card_id' => Card::all('id')->random(1)->first()->id,
            'index' => 1
        ];
    }
}
