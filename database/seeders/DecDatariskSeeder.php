<?php

namespace Database\Seeders;

use App\Models\DecDatariskParam;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DecDatariskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DecDatariskParam::truncate();

        DecDatariskParam::create([
            'path' => "DATARISK/{YEAR}/{MONTH}/{FILENAME}.xlsx",
            'mails_to' => "andre-marie.akuete@orabank.net",
            'mails_cc' => 'andre-marie.akuete@orabank.net',
            'mails_bcc' => 'andre-marie.akuete@orabank.net',
            'message' => "Priere trouver ci-joint les fichiers de déclaration DTARISK du mois de {MONTH}",
        ]);
    }
}
