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
    public function replyto() {
        $thread = Threads::inRandomOrder()->first()->thread_id;
        Threads::where('thread_id',$thread)->increment('replies');
        return $thread;
    }

    public function definition()
    {
        return [
            'reply_id' => $this->faker->numberBetween($min = 1000, $max = 9000),
            'thread_id' => $this->replyto(),
            'name' => 'Anonymous',
            'message' => $this->faker->Paragraph()
        ];
    }
}
