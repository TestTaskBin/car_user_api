<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Info extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:info';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Application status';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info(app()->environment());
        return Command::SUCCESS;
    }
}
