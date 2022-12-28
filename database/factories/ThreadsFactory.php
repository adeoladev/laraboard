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
        $ip = $this->faker->ipv4();
        $board = Board::inRandomOrder()->first()->tag;
        Replies::create([
            'reply_id' => $id,
            'thread_id' => $id,
            'name' => 'Anonymous',
            'message' => $message,
            'thumbnail' => 'files/thumbnails/default.jpg',
            'file' => 'files/default.jpg',
            'ip_address' => $ip,
            'board' => $board
        ]);
        return [
            'thread_id' => $id,
            'name' => 'Anonymous',
            'message' => $message,
            'thumbnail' => 'files/thumbnails/default.jpg',
            'file' => 'files/default.jpg',
            'ip_address' => $ip,
            'archived' => false,
            'pinned' => false,
            'board' => $board
        ];
    }
}
