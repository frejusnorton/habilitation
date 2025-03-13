<?php

namespace App\Console\Commands;

use App\Http\Controllers\BIC\BicController;
use Illuminate\Console\Command;

class BicBkTableCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bic:create-table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup des tables bic';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        BicController::tableCreation();
    }
}
