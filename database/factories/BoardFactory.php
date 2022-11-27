<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Board;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BoardFactory extends Factory
{
    protected $model = Board::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'tag' => $this->faker->randomLetter(),
            'category' => $this->faker->numberBetween($min = 1, $max = 4)
        ];
    }
}
