<?php

namespace App\Console\Commands;

use App\Http\Controllers\DEC\Dec15MController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class Dec15mCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:dec15m';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Declaration centif';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info("BEGIN DECLARATION 15M");

        # Chargement......................
        // Dec15MController::load();

        $ctrl = new Dec15MController();

        # Moral...........................
        Log::info("Begin genMoral");

        $ctrl->genMoral();
        Log::info("End genMoral");

        # Physique........................
        Log::info("Begin genPhysique");

        $ctrl->genPhysique();
        Log::info("End genPhysique");


        Log::info("End DECLARATION 15M");
    }
}
