<?php


namespace App\Http\Controllers\Recap;

use App\Helpers\Helper;
use Carbon\Carbon;

use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Recap\RecapParams;
use Illuminate\Support\Facades\File;
use App\Models\SBA\Recapcom_traitement;
use Illuminate\Support\Facades\Storage;

class GenerationController extends Controller
{


    public static function genReleveComm($annee)
    {

        //Liste des clients pour test

        $codeClient = [
            '220428'
            // '120780',
            // '224746',
            // '248010',
            // '219058',
            // '230734',
            // '252249',
            // '242876',
            // '252273',
        ];

        // $clis = Recapcom_traitement::whereNull('statut')->take(20)->get();

        $clis = Recapcom_traitement::whereIn('cli', $codeClient)->get();


        $sql = File::get(storage_path('recapAnnuel/main.sql'));

        foreach ($clis as  $cli) {

            Log::channel('recap')->info("Début generation $cli->cli");

            $cli->date_traitement = Carbon::now()->format('d/m/Y');
            $cli->heure = Carbon::now()->format('H:i:s');

            $query = self::setParam(":cli", $cli->cli, $sql);

            $datas = DB::connection('dbedi50')->select($query);

            if (sizeof($datas) > 0) {

                //Generation et envoi des releves
                $send = Self::genererReleve($datas, $cli->cli, $annee);

                $cli->statut = $send['status'];
                $cli->motif_erreur = $send['motif'];
                $cli->filepath = isset($send['filename']) && !empty($send['filename']) ? $send['filename'] : '';
            } else {
                $cli->statut = 'ECHEC';
                $cli->motif_erreur = 'PAS DE DONNEE';
            }

            $cli->save();
            Log::channel('recap')->info("Fin generation $cli->cli");
        }
    }


    static function setParam($search, $val, $content)
    {
        return str_replace($search, "'$val'", $content);
    }

    /**
     * Generation de releve

     * @return void
     */
    public static function genererReleve($datas, $cli, $annee)
    {

        $cliInfo = Self::getCliInfo($cli);
        $email = $cliInfo->email;
        if (empty($email) || $email == null) {
            return ['status' => 'ECHEC', 'motif' => "Email non trouvé "];
        }

        $pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
        if (!preg_match($pattern, $email)) {
            return ['status' => 'ECHEC', 'motif' => "Email invalid : " . $email];
        }

        $adresse = $cliInfo->adr;
        $age = $cliInfo->age;
        $agence = $cliInfo->agence;
        $titulaire_compte = $cliInfo->nom_prenom;
        $dev = '';

        $pdf = Pdf::loadView('recap.rlv', [
            'cli' => $cli,
            'titulaire_compte' => $titulaire_compte,
            'adresse' => $adresse,
            'annee' => $annee,
            'agence' => $agence,
            'code_agence' => $age,
            'dev' => $dev,
            'liste_mouvement' => $datas,
        ]);

        $pdf->setPaper('A4', 'portrait')->setWarnings(false);

        $pdf->get_canvas()->get_cpdf()
            ->setEncryption($cli, 5678, ['print', 'modify', 'copy', 'add']);

        $path = config('app.pdf_path') . '/' . $annee . '/';
        $fileName = "RECAPITULATIF_ANNUEL_DES_FRAIS_COMMISSIONS_" . $annee . '_' . $cli . '.pdf';

        // Assurez-vous que le dossier existe avant d'y écrire le fichier
        if (!Storage::disk('appsfile')->exists($path)) {
            Storage::disk('appsfile')->makeDirectory($path); // Crée le dossier s'il n'existe pas
        }

        // Enregistrer le PDF
        Storage::disk('appsfile')->put($path . $fileName, $pdf->output());

        $params = RecapParams::first();

        if ($params) {

            $tos = explode(";", $email);
            $tos = $tos[0];

            $tos = ['andre-marie.akuete@orabank.net'];
            $title = str_replace("{YEAR}", $annee, $params->title_mail);
            $message = str_replace("{YEAR}", $annee, $params->message_mail);
            // $bcc = explode("|", $params->mails_cc);
            $bcc = explode("|", "nabil.kpossa@orabank.net|felicia.kuassi@orabank.net");
        }

        $status = [];

        try {
            $status = Helper::sendRecapMail($title, $message, $fileName, $path, $tos, $bcc, 'appsfile', 'pdf');
        } catch (\Exception $e) {
            $status = ['status' => 'ECHEC', 'motif' => "Echec d'envoi du mail: " . $e->getMessage()];
        }

        return $status;
    }

    public static function getCliInfo($cli)
    {
        $cliInfo = DB::connection('dbedi50')->select("
            SELECT
                BK.AGE,
                BK.LIB,
                getTrueEmail(TRIM(CLI)) EMAIL,
                GetFormattedAddresses(TRIM(CLI)) ADR,
                (SELECT LIB
                FROM BKAGE
                WHERE TRIM(AGE) = BK.AGE
                AND ROWNUM = 1) AS AGENCE,
                TRIM(BK.NOM) || ' ' || TRIM(BK.PRE) AS NOM_PRENOM
            FROM BKCLI BK
            WHERE TRIM(CLI) = ?
        ", [$cli]);
        if ($cliInfo && isset($cliInfo[0])) {
            return  $cliInfo = $cliInfo[0];
        }

        return false;
    }
}
