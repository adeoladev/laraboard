<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laraboard:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates an admin account.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        User::create([
            'username' => 'Admin',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'rank' => 'admin'
        ]);

        return $this->comment('Admin account created!');
        return Command::SUCCESS;
    }
}
