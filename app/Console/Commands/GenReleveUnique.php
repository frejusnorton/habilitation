<?php

namespace App\Console\Commands;

use App\Http\Controllers\Recap\GenerationController;
use App\Models\Recap\RecapParams;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GenReleveUnique extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rlv:unique';

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
        $param = RecapParams::first();
        if ($param && isset($param->annee) && $param->annee != null) {

            GenerationController::genReleveComm($param->annee);
            $this->error('ENVOI EFFECTUE ');

        } else {

            Log::error('Paramétrage annee genération non enregistré');
            $this->error('Parametrage année generation non enregistré.');

        }
    }
}
