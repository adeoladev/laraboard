<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Archive;
use App\Models\Thread;
use Carbon\Carbon;

class NewArchive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'new:archive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Archives expired threads.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $expiredThreads = Thread::where('replies','>',300)->get();
        $deadThreads = Thread::where('replies','<',10)->where('created_at','>',Carbon::now()->subWeek(1)->toDateTimeString())->get();

        foreach($expiredThreads as $thread) {
            $thread->archived = true;
            $thread->save();

            Archive::create([
                'thread' => $thread->id,
                'deletion_date' => Carbon::now()->addMonth()->toDateTimeString()
            ]);
        }

        foreach($deadThreads as $thread) {
            $thread->archived = true;
            $thread->save();

            Archive::create([
                'thread' => $thread->id,
                'deletion_date' => Carbon::now()->addMonth()->toDateTimeString()
            ]);
        }

        return Command::SUCCESS;
    }
}
