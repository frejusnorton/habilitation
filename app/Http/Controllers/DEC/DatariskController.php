<?php

namespace App\Http\Controllers\DEC;

use App\Exports\allExport;
use App\Helpers\Helper_021224;
use App\Http\Controllers\Controller;
use App\Models\DecDatariskParam;
use App\Service\SimpleXLSXGen;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use PDO;

class DatariskController extends Controller
{

    public function reload()
    {
        ini_set("memory_limit", -1);
        set_time_limit(-1);

        Log::channel('datarisk')->info('RELOAD INDEX.');
        //Recharger les indexs
        Self::reloadIndex();

        //DROP des tables
        Log::channel('datarisk')->info('RELOAD DROP.');
        Self::reloadDrop();


        //0_Objet_MAP---------------
        Log::channel('datarisk')->info('BEGIN 0_Objet_MAP.');
        $path = storage_path('datarisk/0_Objet_MAP.sql');
        $ret = SELF::getScriptContent($path);

        // Log::channel('datarisk')->info('END 0_Objet_MAP.');

        //1_DATA RISK---------------
        Log::channel('datarisk')->info('BEGIN 1_DATARISK.');
        $path = storage_path('datarisk/1_DATARISK.sql');
        $ret = SELF::getScriptContent($path);

        Log::channel('datarisk')->info('END 1_DATARISK.');

        //2_IMPAYE---------------
        Log::channel('datarisk')->info('BEGIN 2_IMPAYE.');
        $path = storage_path('datarisk/2_IMPAYE.sql');
        $ret = SELF::getScriptContent($path);



        //5_Compte_DEB_SANS_MVT_significatif---------------

        Log::channel('datarisk')->info('BEGIN 5_Compte_DEB_SANS_MVT_significatif.');
        $path = storage_path('datarisk/5_Compte_DEB_SANS_MVT_significatif.sql');
        $ret = SELF::getScriptContent($path);

        Log::channel('datarisk')->info('END 5_Compte_DEB_SANS_MVT_significatif.');
        return $ret;
    }

    public function generation()
    {
        ini_set("memory_limit", -1);
        set_time_limit(-1);

        Log::channel('datarisk')->info('BEGIN 2_IMPAYE.');
        $this->impaye();
        Log::channel('datarisk')->info('END 2_IMPAYE.');

        Log::channel('datarisk')->info('BEGIN 3_RESTRUCTURES.');
        $this->restructures();
        Log::channel('datarisk')->info('END 3_RESTRUCTURES.');

        Log::channel('datarisk')->info('BEGIN 4_DEBITEURS.');
        $this->debiteur();
        Log::channel('datarisk')->info('END 4_DEBITEURS.');

        Log::channel('datarisk')->info('BEGIN 5_DEBITEUR_SANS_MVT.');
        $this->compteDebSansMvt();
        Log::channel('datarisk')->info('END 5_DEBITEUR_SANS_MVT.');

        Log::channel('datarisk')->info('BEGIN 7_GARANTIE.');
        $this->garantie();
        Log::channel('datarisk')->info('END 7_GARANTIE.');

        Log::channel('datarisk')->info('BEGIN 8_HORS_BILAN.');
        $this->garantie();
        Log::channel('datarisk')->info('END 8_HORS_BILAN.');

        Log::channel('datarisk')->info('BEGIN 9_PRET');
        $this->garantie();
        Log::channel('datarisk')->info('END 9_PRET');

        Log::channel('datarisk')->info('BEGIN 9_PRET');
        $this->pret();
        Log::channel('datarisk')->info('END 9_PRET');

        Log::channel('datarisk')->info('BEGIN 10_BALANCE');
        $this->balance();
        Log::channel('datarisk')->info('END 10_BALANCE');
    }

    /**
     * géneration impaye
     *
     * @return void
     */
    public static function impaye()
    {
        Log::info('Début generation IMPAYE');

        $sql = File::get(storage_path('datarisk/2_IMPAYE_SELECT.sql'));

        $data = DB::connection('dbedi')->select($sql);
        $month = Helper_021224::getMonth();
        $params = SELF::getParams();
        $fileName = "2_IMPAYE_" . $month;

        $path = str_replace("{YEAR}", Helper_021224::getYearDec(), $params->path);
        $path = str_replace("{FILENAME}", $fileName, $path);
        $path = str_replace("{MONTH}", $month, $path);

        Excel::store(new allExport('datarisk.impaye', ['datas' => $data]), $path, 'appsfile');
        Log::info('Fin generation IMPAYE');
    }

    /**
     * géneration Restructures
     *
     * @return void
     */
    public static function restructures()
    {
        Log::info('Début generation RESTRUCTURES');

        $sql = File::get(storage_path('datarisk/3_RESTRUCTURES_SELECT.sql'));
        $sql = self::setParam(":DATE_EXTRACT", Helper_021224::previousMonth(), $sql);
        $data = DB::connection('dbedi')->select($sql);
        dd($data);
        $month = Helper_021224::getMonth();
        $params = SELF::getParams();
        $fileName = "3_RESTRUCTURES_" . $month;

        $path = str_replace("{YEAR}", Helper_021224::getYearDec(), $params->path);
        $path = str_replace("{FILENAME}", $fileName, $path);
        $path = str_replace("{MONTH}", $month, $path);

        Excel::store(new allExport('datarisk.restructure', ['datas' => $data]), $path, 'appsfile');
        Log::info('Fin generation RESTRUCTURES');
    }

    /**
     * géneration COMPTES_DEBITEURS
     *
     * @return void
     */
    public static function debiteur()
    {
        Log::info('Début generation COMPTES_DEBITEURS');

        $sql = File::get(storage_path('datarisk/4_COMPTES_DEBITEURS_SELECT.sql'));
        $sql = self::setParam(":DATE_EXTRACT", Helper_021224::previousMonth(), $sql);
        $data = DB::connection('dbedi')->select($sql);
        dd($data);
        $month = Helper_021224::getMonth();
        $params = SELF::getParams();
        $fileName = "4_COMPTES_DEBITEURS_" . $month;

        $path = str_replace("{YEAR}", Helper_021224::getYearDec(), $params->path);
        $path = str_replace("{FILENAME}", $fileName, $path);
        $path = str_replace("{MONTH}", $month, $path);

        Excel::store(new allExport('datarisk.debiteur', ['datas' => $data]), $path, 'appsfile');
        Log::info('Fin generation COMPTES_DEBITEURS');
    }

    /**
     * géneration COMPTES_DEBITEURS
     *
     * @return void
     */
    public static function compteDebSansMvt()
    {
        Log::info('Début generation COMPTE_DEB_SANS_MVT_SIGNIFICATIF');

        $sql = File::get(storage_path('datarisk/5_COMPTE_DEB_SANS_MVT_SIGNIFICATIF_SELECT.sql'));
        $sql = self::setParam(":DATE_EXTRACT", Helper_021224::previousMonth(), $sql);
        $data = DB::connection('dbedi')->select($sql);

        $month = Helper_021224::getMonth();
        $params = SELF::getParams();
        $fileName = "5_COMPTE_DEB_SANS_MVT_SIGNIFICATIF_" . $month;

        $path = str_replace("{YEAR}", Helper_021224::getYearDec(), $params->path);
        $path = str_replace("{FILENAME}", $fileName, $path);
        $path = str_replace("{MONTH}", $month, $path);

        Excel::store(new allExport('datarisk.debsanmvt', ['datas' => $data]), $path, 'appsfile');
        Log::info('Fin generation COMPTE_DEB_SANS_MVT_SIGNIFICATIF');
    }

    /**
     * géneration CREANCE DOUTEUSES
     *
     * @return void
     */
    public static function creanceDouteuses()
    {
        Log::info('Début generation CREANCE DOUTEUSES ');

        $sql = File::get(storage_path('datarisk/6_CREANCE_DOUTEUSES_SELECT.sql'));
        $sql = self::setParam(":DATE_EXTRACT", Helper_021224::previousMonth(), $sql);
        $data = DB::connection('dbedi')->select($sql);

        $month = Helper_021224::getMonth();
        $params = SELF::getParams();
        $fileName = "6_CREANCE_DOUTEUSES_" . $month;

        $path = str_replace("{YEAR}", Helper_021224::getYearDec(), $params->path);
        $path = str_replace("{FILENAME}", $fileName, $path);
        $path = str_replace("{MONTH}", $month, $path);

        Excel::store(new allExport('datarisk.douteux', ['datas' => $data]), $path, 'appsfile');
        Log::info('Fin generation CREANCE_DOUTEUSES');
    }

    /**
     * géneration Hors Bilan
     *
     * @return void
     */
    public static function horsBilan()
    {
        Log::info('Début generation Hors BILAN ');

        $sql = File::get(storage_path('datarisk/8_Hors_BILAN_SELECT.sql'));
        $sql = self::setParam(":DATE_EXTRACT", Helper_021224::previousMonth(), $sql);
        $data = DB::connection('dbedi')->select($sql);

        $month = Helper_021224::getMonth();
        $params = SELF::getParams();
        $fileName = "8_Hors_BILAN_" . $month;

        $path = str_replace("{YEAR}", Helper_021224::getYearDec(), $params->path);
        $path = str_replace("{FILENAME}", $fileName, $path);
        $path = str_replace("{MONTH}", $month, $path);

        Excel::store(new allExport('datarisk.horsBilan', ['datas' => $data]), $path, 'appsfile');
        Log::info('Fin generation GARANTIE');
    }


    /**
     * géneration garantie
     *
     * @return void
     */
    public static function garantie()
    {
        Log::info('Début generation GARANTIE');

        $sql = File::get(storage_path('datarisk/7_GARANTIE_SELECT.sql'));
        $sql = self::setParam(":DATE_EXTRACT", Helper_021224::previousMonth(), $sql);
        $data = DB::connection('dbedi')->select($sql);

        $month = Helper_021224::getMonth();
        $params = SELF::getParams();
        $fileName = "7_GARANTIE_" . $month;

        $path = str_replace("{YEAR}", Helper_021224::getYearDec(), $params->path);
        $path = str_replace("{FILENAME}", $fileName, $path);
        $path = str_replace("{MONTH}", $month, $path);

        Excel::store(new allExport('datarisk.garantie', ['datas' => $data]), $path, 'appsfile');
        Log::info('Fin generation GARANTIE');
    }

    /**
     * géneration pret
     *
     * @return void
     */
    public static function pret()
    {
        Log::info('Début generation PRET');

        $sql = File::get(storage_path('datarisk/9_PRET_SELECT.sql'));
        $sql = self::setParam(":DATE_EXTRACT", Helper_021224::previousMonth(), $sql);
        $data = DB::connection('dbedi')->select($sql);

        $month = Helper_021224::getMonth();
        $params = SELF::getParams();
        $fileName = "9_PRET_" . $month;

        $path = str_replace("{YEAR}", Helper_021224::getYearDec(), $params->path);
        $path = str_replace("{FILENAME}", $fileName, $path);
        $path = str_replace("{MONTH}", $month, $path);

        Excel::store(new allExport('datarisk.pret', ['datas' => $data]), $path, 'appsfile');
        Log::info('Fin generation PRET');
    }

    /**
     * géneration balance
     *
     * @return void
     */
    public static function balance()
    {
        Log::info('Début generation BALANCE');

        $sql = File::get(storage_path('datarisk/10_BALANCE_SELECT.sql'));
        $sql = self::setParam(":DATE_EXTRACT", Helper_021224::previousMonth(), $sql);
        $data = DB::connection('dbedi')->select($sql);

        $month = Helper_021224::getMonth();
        $params = SELF::getParams();
        $fileName = "10_BALANCE_" . $month;

        $path = str_replace("{YEAR}", Helper_021224::getYearDec(), $params->path);
        $path = str_replace("{FILENAME}", $fileName, $path);
        $path = str_replace("{MONTH}", $month, $path);

        Excel::store(new allExport('datarisk.balance', ['datas' => $data]), $path, 'appsfile');
        Log::info('Fin generation BALANCE');
    }

    public static function getScriptContent($path)
    {
        if (!File::exists($path)) {
            return 'FAILED';
        }

        $sql = File::get($path);

        // Split the SQL statements by the delimiter
        $statements = explode('##', $sql);

        // Execute each SQL statement
        foreach ($statements as $statement) {

            $trimmedStatement = trim($statement);

            if (!empty($trimmedStatement)) {

                $query = self::setParam(":DATE_EXTRACT", Helper_021224::previousMonth(), $trimmedStatement);
                // $query = self::setParam(":DATE_EXTRA", Helper::previousMonth(), $trimmedStatement);
                dump($query);
                DB::connection('dbedi')->unprepared($query);
            }
        }
        return 'SUCCESS';
    }


    static function setParam($search, $val, $content)
    {
        return  str_replace($search, "'$val'", $content);
    }


    public static function reloadIndex()
    {
        Log::channel('datarisk')->info('BEGIN IDX_DATRISK_71C00001.');

        $exist = DB::connection('dbedi')->select("SELECT INDEX_NAME
        FROM USER_INDEXES
        WHERE INDEX_NAME = 'IDX_DATRISK_71C00001'");

        if (sizeof($exist) == 0) {
            DB::connection('dbedi')->statement(' CREATE INDEX "DBEDI"."IDX_DATRISK_71C00001" ON "DBEDI"."BKDOSPRT" (TRIM("CLI"), "ETA", "DMEP")TABLESPACE "INDXDBS"');
        }

        Log::channel('datarisk')->info('END IDX_DATRISK_71C00001.');

        Log::channel('datarisk')->info('DEBUT IDX_DATRISK_71C00002.');
        $exist = DB::connection('dbedi')->select("SELECT INDEX_NAME
        FROM USER_INDEXES
        WHERE INDEX_NAME = 'IDX_DATRISK_71C00002'");

        if (sizeof($exist) == 0) {
            DB::connection('dbedi')->statement(' CREATE INDEX "DBEDI"."IDX_DATRISK_71C00002" ON "DBEDI"."BKECHPRT" ("EVE", "AVE") TABLESPACE "INDXDBS"');
        }

        Log::channel('datarisk')->info('FIN IDX_DATRISK_71C00002.');
        Log::channel('datarisk')->info('DEBUT IDX_DATRISK_71C50001.');

        $exist = DB::connection('dbedi')->select("SELECT INDEX_NAME
        FROM USER_INDEXES
        WHERE INDEX_NAME = 'IDX_DATRISK_71C50001'");

        if (sizeof($exist) == 0) {
            DB::connection('dbedi')->statement('CREATE INDEX "DBEDI"."IDX_DATRISK_71C50001" ON "DBEDI"."BKNOM" ("CACC", DECODE(TRIM("LIB2"),\'280\',\'OTG\',\'284\',\'OBJ\',\'OCI\')) TABLESPACE "INDXDBS"');
        }

        Log::channel('datarisk')->info('END IDX_DATRISK_71C50001.');

        Log::channel('datarisk')->info('DEBUT IDX_DATRISK_83DA0001.');
        $exist = DB::connection('dbedi')->select("SELECT INDEX_NAME
        FROM USER_INDEXES
        WHERE INDEX_NAME = 'IDX_DATRISK_83DA0001'");

        if (sizeof($exist) == 0) {
            DB::connection('dbedi')->statement('CREATE INDEX "DBEDI"."IDX_DATRISK_83DA0001" ON "DBEDI"."BKSLD" (\'CLI\', \'DCO\', \'SDE\') TABLESPACE "INDXDBS"');
        }
        Log::channel('datarisk')->info('END IDX_DATRISK_83DA0001.');

        Log::channel('datarisk')->info('DEBUT idx_deb6M.');

        $exist = DB::connection('dbedi')->select("SELECT INDEX_NAME
        FROM USER_INDEXES
        WHERE INDEX_NAME = 'idx_deb6M'");

        if (sizeof($exist) == 0) {
            DB::connection('dbedi')->statement('CREATE INDEX idx_deb6M ON ORA_DATARISK5(deb6M)');
        }
        Log::channel('datarisk')->info('END idx_deb6M.');

    }

    public function reloadDrop()
    {
        Schema::connection('dbedi')->dropIfExists('ora_datarisk_IMP');
        Schema::connection('dbedi')->dropIfExists('ora_datarisk');
        Schema::connection('dbedi')->dropIfExists('ORA_DATARISK5');
    }

    public static function getParams()
    {
        return DecDatariskParam::first();
    }
}
