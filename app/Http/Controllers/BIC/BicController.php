<?php

namespace App\Http\Controllers\BIC;



use App\Exports\allExport;
use App\Helpers\Helper;
use App\Service\SimpleXLSX;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Bic\BicDeclaration;
use App\Models\Bic\BicDeclarationEnCours;
use App\Service\UploadFile;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class BicController extends Controller
{
    /**
     * Chargement des fichiers de declaration passé
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        if ($request->post()) {

            ini_set("memory_limit", -1);
            set_time_limit(-1);


            $request->validate([
                'excel_file' => 'required|mimes:xlsx,xml',
            ]);
            //Récuperation date de déclaration ----------------------------------

            $mois_annee = Carbon::parse($request->date)->format('Y-m');

            if ($request->file('excel_file')->getClientOriginalExtension() === "xlsx") {
                //Upload file
                $filePath = UploadFile::uploadFile($request->file('excel_file'), 'BIC/UPLOAD');


                //recuperation des lignes
                $xls = new SimpleXLSX($filePath);
                $content = $xls->rows();

                if ($content) {

                    $allData = [];

                    foreach ($content as $index => $row) {
                        if ($index == 0) continue;

                        if (empty(trim($row[0])) || empty(trim($row[1]))) {
                            return redirect()->back()->withErrors(['error' => 'Un des champs requis est vide dans le fichier.']);
                        }

                        $rowData = [
                            'REFERENCE' => trim($row[0]),
                            'STATUT' => trim($row[1]),
                            'MOIS_ANNEE' => $mois_annee
                        ];
                        $allData[] = $rowData;
                    }

                    $collection = collect($allData);

                    $chunks = $collection->chunk(100);

                    $chunks->toArray();


                    foreach ($chunks as $chunk) {
                        foreach ($chunk as $row) {

                            BicDeclarationEnCours::updateOrInsert(
                                [
                                    'REFERENCE' => $row['REFERENCE'],
                                    'MOIS_ANNEE' => $row['MOIS_ANNEE'],
                                ],
                                [
                                    'STATUT' => $row['STATUT'],
                                ]
                            );
                        };
                    }
                    return redirect()->route('bic.chargement')->with('success', 'Chargement terminé avec succès');
                } else {
                    return redirect()->back()->withErrors(['error' => "Le fichier est vide ou le format est incorrect."]);
                }
            } else {

                if ($request->file('excel_file')->getClientOriginalExtension() === "xml") {
                    $request->validate([
                        'excel_file' => 'required|mimes:xml',
                    ]);

                    $originalName = pathinfo($request->file('excel_file')->getClientOriginalName(), PATHINFO_FILENAME);

                    $extension = $request->file('excel_file')->getClientOriginalExtension();
                    $currentDate = now()->format('Y_m_d_H_i');

                    $fileName = "{$originalName}_{$currentDate}.{$extension}";
                    $request->file('excel_file')->move(public_path('BIC/UPLOAD'), $fileName);

                    $filePath = public_path("BIC/UPLOAD/$fileName");

                    $xml = simplexml_load_file($filePath);
                    if ($xml === false) {
                        return redirect(route('bic.chargement'))->with('error', 'Erreur lors du chargement du fichier');
                    }

                    foreach ($xml->Contract as $contract) {
                        $contractCode = trim($contract->ContractCode);
                        $phaseOfContract = trim($contract->ContractData->PhaseOfContract);

                        $data = [
                            'CONTRATCODE' => $contractCode,
                            'PHASEOFCONTRAT' => $phaseOfContract,
                            'MOIS_ANNEE' => $mois_annee
                        ];

                        BicDeclarationEnCours::updateOrInsert(
                            [
                                'REFERENCE' => $data['CONTRATCODE'],
                                'MOIS_ANNEE' => $data['MOIS_ANNEE'],
                            ],
                            [
                                'STATUT' => $data['PHASEOFCONTRAT'],
                            ]
                        );
                    }
                } else {
                    return redirect(route('bic.chargement'))->with('error', 'Le fichier est vide ou le format est incorrect.');
                }
                return redirect(route('bic.chargement'))->with('success', 'Fichier  téléversé avec succès');
            }
        }
        return view('bic.load');
    }

    public static  function generateEffets($mois_annee)
    {

        Log::info('Début generation EFFECTS');

        $sql = File::get(storage_path('BIC/EFFET.sql'));

        //date de debut et de fin periode
        $dates = Helper::getFirstAndLastDayOfPreviousMonth();

        $lastF = Carbon::createFromFormat('d/m/Y', $dates['last_day'])->format('dmY');

        //Mise à jour des parametres
        $sql = self::setParam(":date_debut_periode", $dates['first_day'], $sql);
        $sql = self::setParam(":date_fin_periode", $dates['last_day'], $sql);
        $sql = self::setParam(":MOIS_ANNEE", $mois_annee, $sql);
        $sql = self::setParamTable("#DATE_EXTRACT", $lastF, $sql);

        //Extractions
        $data = DB::connection('bic')->select($sql);

        Log::info(sizeof($data));
        //Generation des fichiers
        $path = Helper::getYearDec() . '/' . Helper::getMonth() . '/' . "EFFETS_" . Helper::getMonth() . '_' . Helper::getYearDec() . '.xlsx';

        Excel::store(new allExport('default.table', ['datas' => $data]), $path, 'appsfile');

        Log::info('Fin generation EFFECTS');
        return 'Done';
    }


    public static  function generateCredits($mois_annee)
    {

        Log::info('Début generation CREDITS');

        $sql = File::get(storage_path('BIC/CREDIT.sql'));

        //date de debut et de fin periode
        $dates = Helper::getFirstAndLastDayOfPreviousMonth();

        $lastF = Carbon::createFromFormat('d/m/Y', $dates['last_day'])->format('dmY');

        //Mise à jour des parametres
        $sql = self::setParam(":date_debut_periode", $dates['first_day'], $sql);
        $sql = self::setParam(":date_fin_periode", $dates['last_day'], $sql);
        $sql = self::setParam(":MOIS_ANNEE", $mois_annee, $sql);
        $sql = self::setParamTable("#DATE_EXTRACT", $lastF, $sql);

        Log::info($sql);
        //Extractions
        $data = DB::connection('bic')->select($sql);

        Log::info(sizeof($data));
        //Generation des fichiers
        $path = Helper::getYearDec() . '/' . Helper::getMonth() . '/' . "CREDITS_" . Helper::getMonth() . '_' . Helper::getYearDec() . '.xlsx';

        Excel::store(new allExport('default.table', ['datas' => $data]), $path, 'appsfile');

        Log::info('Fin generation CREDITS');
        return 'Done';
    }

    public static  function generateCautions()
    {

        Log::info('Début generation EFFECTS');

        $sql = File::get(storage_path('BIC/EFFET.sql'));

        //date de debut et de fin periode
        $dates = Helper::getFirstAndLastDayOfPreviousMonth();

        $dates['first_day'] = '01/08/2024';
        $dates['last_day'] = '30/08/2024';

        $sql = self::setParam(":date_debut_periode", $dates['first_day'], $sql);
        $sql = self::setParam(":date_fin_periode", $dates['last_day'], $sql);
        $sql = self::setParam(":MOIS_ANNEE", '2024-09', $sql);
        $sql = self::setParamTable(":DATE_IMPORT", '30082024', $sql);

        $data = DB::connection('bic')->select($sql);

        $path = Helper::getYearDec() . '/' . Helper::getMonth() . '/' . "EFFETS_" . Helper::getMonth() . '_' . Helper::getYearDec();

        Excel::store(new allExport('datarisk.balance', ['datas' => $data]), $path, 'appsfile');

        return $data;

        Log::info('Fin generation EFFECTS');
    }

    public static function reloadList($mois_annee)
    {
        ini_set("memory_limit", -1);
        set_time_limit(-1);


        //Récuperation des contrats precedents non clos

        //vider table de déclaration
        BicDeclaration::truncate();

        $prev = BicDeclarationEnCours::where('MOIS_ANNEE', $mois_annee)->where('STATUT', 'Open')->get();
        Log::info("Nb lignes Open :" . sizeof($prev));
        if ($prev) {

            collect($prev)->chunk(1000)->each(function ($chunk) {
                $data = [];
                foreach ($chunk as $row) {
                    $exist = BicDeclaration::where('REFERENCE', $row->reference)->exists();
                    if (!$exist) {
                        $data[] = ['REFERENCE' => $row->reference];
                    }
                }
                if (sizeof($data) > 0) {
                    BicDeclaration::insert($data);
                }
            });
        }

        $cautions = Self::getCautions();
        Log::info("Nb lignes Cautions :" . sizeof($cautions));

        if ($cautions) {

            collect($cautions)->chunk(1000)->each(function ($chunk) {
                $data = [];
                foreach ($chunk as $row) {
                    $exist = BicDeclaration::where('REFERENCE', $row->contractcode)->exists();
                    if (!$exist) {
                        $data[] = ['REFERENCE' => $row->contractcode];
                    }
                }
                if (sizeof($data) > 0) {
                    BicDeclaration::insert($data);
                }
            });
        }

        $credits = Self::getCredit();
        Log::info("Nb lignes credits :" . sizeof($credits));

        if ($credits) {

            collect($credits)->chunk(1000)->each(function ($chunk) {
                $data = [];
                foreach ($chunk as $row) {
                    $exist = BicDeclaration::where('REFERENCE', $row->reference)->exists();
                    if (!$exist) {
                        $data[] = ['REFERENCE' => $row->reference];
                    }
                }
                if (sizeof($data) > 0) {
                    BicDeclaration::insert($data);
                }
            });
        }

        $effets = Self::getEffets();
        Log::info("Nb lignes effets :" . sizeof($effets));

        if ($effets) {

            collect($effets)->chunk(1000)->each(function ($chunk) {
                $data = [];
                foreach ($chunk as $row) {
                    $exist = BicDeclaration::where('REFERENCE', $row->reference)->exists();
                    if (!$exist) {
                        $data[] = ['REFERENCE' => $row->reference];
                    }
                }
                if (sizeof($data) > 0) {
                    BicDeclaration::insert($data);
                }
            });
        }

        $auths = Self::getAutorisations();
        Log::info("Nb lignes auths :" . sizeof($auths));

        if ($auths) {

            collect($auths)->chunk(1000)->each(function ($chunk) {
                $data = [];
                foreach ($chunk as $row) {
                    $exist = BicDeclaration::where('REFERENCE', $row->reference)->exists();
                    if (!$exist) {
                        $data[] = ['REFERENCE' => $row->reference];
                    }
                }
                if (sizeof($data) > 0) {
                    BicDeclaration::insert($data);
                }
            });
        }

        return 'done';
    }

    public static function getCautions()
    {
        // $params = self::getParams();
        // dd($params);

        Log::info('Début generation CAUTIONS');

        $sql = File::get(storage_path('BIC/CAUTION_INSERT.sql'));

        //date de debut et de fin periode
        $dates = Helper::getFirstAndLastDayOfPreviousMonth();

        // $dates['first_day'] = '01/08/2024';
        // $dates['last_day'] = '10/08/2024';
        $lastF = Carbon::createFromFormat('d/m/Y', $dates['last_day'])->format('dmY');

        $sql = self::setParam(":date_debut_periode", $dates['first_day'], $sql);
        $sql = self::setParam(":date_fin_periode", $dates['last_day'], $sql);
        $sql = self::setParamTable("#DATE_EXTRACT", $lastF, $sql);


        return DB::connection('bic')->select($sql);

        Log::info('Fin generation EFFECTS');
    }

    public static function getCredit()
    {

        Log::info('Début generation CREDIT');

        $sql = File::get(storage_path('BIC/CREDIT_INSERT.sql'));

        //date de debut et de fin periode
        $dates = Helper::getFirstAndLastDayOfPreviousMonth();

        // $dates['first_day'] = '01/08/2024';
        // $dates['last_day'] = '10/08/2024';

        $lastF = Carbon::createFromFormat('d/m/Y', $dates['last_day'])->format('dmY');

        $sql = self::setParam(":date_debut_periode", $dates['first_day'], $sql);
        $sql = self::setParam(":date_fin_periode", $dates['last_day'], $sql);
        $sql = self::setParamTable("#DATE_EXTRACT", $lastF, $sql);


        return  DB::connection('bic')->select($sql);
        Log::info('Fin generation CREDITS');
    }

    public static function getEffets()
    {

        Log::info('Début generation EFFET');

        $sql = File::get(storage_path('BIC/EFFET_INSERT.sql'));

        //date de debut et de fin periode
        $dates = Helper::getFirstAndLastDayOfPreviousMonth();

        // $dates['first_day'] = '01/08/2024';
        // $dates['last_day'] = '10/08/2024';

        $lastF = Carbon::createFromFormat('d/m/Y', $dates['last_day'])->format('dmY');

        $sql = self::setParam(":date_debut_periode", $dates['first_day'], $sql);
        $sql = self::setParam(":date_fin_periode", $dates['last_day'], $sql);
        $sql = self::setParamTable("#DATE_EXTRACT", $lastF, $sql);



        Log::info('Fin generation EFFET');

        return  DB::connection('bic')->select($sql);
    }

    public static function getAutorisations()
    {

        Log::info('Début generation Autorisation');

        $sql = File::get(storage_path('BIC/AUTORISATION_INSERT.sql'));

        //date de debut et de fin periode
        $dates = Helper::getFirstAndLastDayOfPreviousMonth();

        // $dates['first_day'] = '01/08/2024';
        // $dates['last_day'] = '10/08/2024';

        $lastF = Carbon::createFromFormat('d/m/Y', $dates['last_day'])->format('dmY');

        $sql = self::setParam(":date_debut_periode", $dates['first_day'], $sql);
        $sql = self::setParam(":date_fin_periode", $dates['last_day'], $sql);
        $sql = self::setParamTable("#DATE_EXTRACT", $lastF, $sql);



        Log::info('Fin generation EFFET');

        return  DB::connection('bic')->select($sql);
    }

    static function setParam($search, $val, $content)
    {
        return str_replace($search, "'$val'", $content);
    }
    static function setParamTable($search, $val, $content)
    {
        return str_replace($search, $val, $content);
    }

    public static function tableCreation()
    {

        $sql = File::get(storage_path('BIC/CREATE_TABLES.sql'));


        $statements = explode('##', $sql);

        foreach ($statements as $statement) {

            $trimmedStatement = trim($statement);

            if (!empty($trimmedStatement)) {

                $query = self::setParam(":DATE_EXTRACT", Helper::previousMonth(), $trimmedStatement);
                dump($query);
                DB::connection('bic')->unprepared($query);
            }
        }
        return 'SUCCESS';
    }
}
