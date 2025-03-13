<?php

namespace App\Console\Commands;

use App\Http\Controllers\BIC\BicController;
use Illuminate\Console\Command;

class BicLoadCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bic:load';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recharger des tables bic';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $mois_annee = '2024-11';
        //Rechargement des tables
        BicController::reloadList($mois_annee);

        //Géneration effets
        // BicController::generateEffets($mois_annee);
        // BicController::generateCredits($mois_annee);

        return 'Done';
    }
}
