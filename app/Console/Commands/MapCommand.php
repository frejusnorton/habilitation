<?php

namespace App\Console\Commands;

use App\Http\Controllers\DEC\DatariskController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class MapCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:map';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        #Begin MAP_______________________________
        Log::channel('datarisk')->info('BEGIN RELOAD');
        $ctrl = new DatariskController();

        $ctrl->reload();

        Log::channel('datarisk')->info('END RELOAD');

        Log::channel('datarisk')->info('BEGIN GENERATION');
        $ctrl = new DatariskController();

        $ctrl->generation();

        Log::channel('datarisk')->info('END GENERATION');

        #End MAP_______________________________
    }
}
