<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Archive;

class DeleteArchive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:archive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes expired archives.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $archives = Archive::all();

        foreach($archives as $archive) {
            if($archive->deletion_date < Carbon::now()) {
              $archive->delete();
              Thread::find($archive->thread)->delete();
              Replies::where('thread_id',$archive->thread)->delete();
            }
        }

        return Command::SUCCESS;
    }
}
