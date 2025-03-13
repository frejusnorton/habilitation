<?php

namespace App\Http\Controllers\Recap;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\SBA\Recapcom_traitement;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class RecapMonitorController extends Controller
{
    public function index()
    {

        $enAttente = DB::connection('objapp')->select("SELECT COALESCE(STATUT, 'EN_ATTENTE') STATUT,count(cli) NB
            FROM RECAPCOM_TRAITEMENT
            WHERE STATUT IS NULL
            GROUP BY STATUT
        ");

        $success = DB::connection('objapp')->select("SELECT COALESCE(STATUT, 'EN_ATTENTE') STATUT,count(cli)  nb
            FROM RECAPCOM_TRAITEMENT
            WHERE STATUT = 'SUCCESS'
            GROUP BY STATUT
        ");

        $echec = DB::connection('objapp')->select("SELECT COALESCE(STATUT, 'EN_ATTENTE') STATUT,count(cli) nb
            FROM RECAPCOM_TRAITEMENT
            WHERE STATUT = 'ECHEC'
            GROUP BY STATUT
        ");

        $total = DB::connection('objapp')->select("SELECT count(cli) nb
            FROM RECAPCOM_TRAITEMENT

        ");


        return view('recap.index', [
            'enAttente' => $enAttente ? $enAttente[0] : null,
            'success' => $success ? $success[0] : null,
            'echec' => $echec ? $echec[0] : null,
            'total' => $total ? $total[0] : null,
        ]);
    }

    public function liste(Request $request)
    {

        if ($request->post()) {
            return self::genReleveUnique($request->cli);
        }
        return view('recap.generer', [
            'cli' => $request->cli
        ]);
    }

    /**
     *
     */
    public static function genReleveUnique($cli)
    {
        $annee = Helper::getYear();

        //Liste des clients pour test
        $sql = File::get(storage_path('recapAnnuel/main.sql'));

        $query = self::setParam(":cli", $cli, $sql);

        $datas = DB::connection('dbedi50')->select($query);

        if (sizeof($datas) > 0) {
            return Self::genererReleve($datas, $cli, $annee);
        } else {
            return 'Aucune donnée pour ce client';
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

        $fileName = "RECAPITULATIF_ANNUEL_DES_FRAIS_COMMISSIONS_" . $annee . '_' . $cli . '.pdf';

        return $pdf->download($fileName);

        // $path = 'temp/'; // Chemin relatif
        // $filePath = storage_path('app/' . $path . $fileName); // Génère le chemin absolu


        // if (!Storage::exists($path)) {
        //     Storage::makeDirectory($path);
        // }

        // file_put_contents($filePath, $pdf->output());

        // dd($filePath);
        // return response()->download($filePath)->deleteFileAfterSend(true);

        // // Retourner une erreur si le fichier n'existe pas
        // return response()->json([
        //     'message' => 'Le fichier PDF n\'a pas pu être généré.',
        // ], 500);
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

    public function getClient(Request $request)
    {
        return response()->json(Helper::getIntitule($request->q));
    }
}
