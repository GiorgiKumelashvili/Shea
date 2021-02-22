<?php /** @noinspection PhpMissingFieldTypeInspection */

namespace Database\Factories;

use App\Models\Card;
use Illuminate\Database\Eloquent\Factories\Factory;

class CardFactory extends Factory {
    protected $model = Card::class;

    public function definition(): array {
        return [
            'name' => $this->faker->name,
            'color' => $this->faker->hexColor,
            'location' => $this->faker->randomElement([1,2]),
            'index' => 1
        ];
    }
}
