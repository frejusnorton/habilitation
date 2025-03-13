<?php

namespace Database\Seeders;

use App\Models\Dec15mParams;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Dec15mParamsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Dec15mParams::truncate();
        Dec15mParams::create([
            'filename_physique' => '15MILLIONS_PERSONNE_PHYSIQUE_{MONTH}',
            'filename_moral' => "15MILLIONS_PERSONNE_MORALE_{MONTH}",
            'path' => "15M/{YEAR}/{MONTH}/{FILENAME}.xlsx",
            'mails_to' => "andre-marie.akuete@orabank.net|salime.salikou@orabank.net|felicia.kuassi@orabank.net",
            'mails_cc' => 'felicia.kuassi@orabank.net',
            'mails_bcc' => '',
            'message_physique' => "Priere trouver ci-joint le fichier de déclaration personne physique centif du mois de {MONTH}",
            'message_morale' => "Priere trouver ci-joint le fichier de déclaration personne physique centif du mois de {MONTH}"
        ]);
    }
}
