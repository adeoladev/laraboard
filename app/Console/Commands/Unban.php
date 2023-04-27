<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ban;
use Carbon\Carbon;

class Unban extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'unban:people';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Unbans expired bans.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $bans = Ban::where('expiration_date','<',Carbon::now()->toDateTimeString())->get();

        foreach($bans as $ban) {
            $ban->delete();
        }

        return $this->comment($bans->count().' people unbanned!');
        return Command::SUCCESS;
    }
}
