<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Threads;
use App\Models\Board;
use App\Models\Replies;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ThreadsFactory extends Factory
{
    protected $model = Threads::class;
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $id = $this->faker->numberBetween($min = 1000, $max = 9000);
        $message = $this->faker->Paragraph();
        Replies::create([
            'reply_id' => $id,
            'thread_id' => $id,
            'name' => 'Anonymous',
            'message' => $message,
            'thumbnail' => 'https://i.imgur.com/turFgMZ.jpg',
            'image' => 'https://i.imgur.com/turFgMZ.jpg'
        ]);
        return [
            'thread_id' => $id,
            'name' => 'Anonymous',
            'message' => $message,
            'image' => 'https://i.imgur.com/turFgMZ.jpg',
            'thumbnail' => 'https://i.imgur.com/turFgMZ.jpg',
            'board' => Board::inRandomOrder()->first()->tag
        ];
    }
}
