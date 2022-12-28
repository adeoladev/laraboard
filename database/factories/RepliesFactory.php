<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Replies;
use App\Models\Threads;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Replies>
 */
class RepliesFactory extends Factory
{
    protected $model = Replies::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition()
    {
        $thread = Threads::inRandomOrder()->first();
        Threads::where('thread_id',$thread->thread_id)->increment('replies');
        return [
            'reply_id' => $this->faker->numberBetween($min = 1000, $max = 9000),
            'thread_id' => $thread->thread_id,
            'name' => 'Anonymous',
            'message' => $this->faker->Paragraph(),
            'ip_address' => $this->faker->ipv4(),
            'board' => $thread->board
        ];
    }
}
