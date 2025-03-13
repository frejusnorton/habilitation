<?php

namespace App\Http\Controllers\DEC;

use Carbon\Carbon;
use App\Helpers\Helper;
use App\Exports\allExport;
use App\Http\Controllers\Controller;
use App\Models\Dec15mParams;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\PHPMailer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Schema;

class Dec15MController extends Controller
{
    /**
     * géneration fichier centif personne physique
     *
     * @return void
     */
    public function genPhysique()
    {


        ini_set("memory_limit", -1);
        set_time_limit(-1);

        $data = SELF::physique();

        $monthNumber = Carbon::now()->format('m');
        $monthNumber = $monthNumber - 1;
        $month = Helper::mois($monthNumber);

        $params = SELF::getParams();

        // $fileName = $params->FILENAME_PHYSIQUE . $month;

        $fileName = str_replace("{MONTH}", $month, $params->filename_physique);

        // $path = '15M/' . $fileName . '.xlsx';
        $path = str_replace("{FILENAME}", $fileName, $params->path);

        // Export and save the file to the specified path
        // Excel::store(new allExport('dec15m.physique', ['datas' => $data]), $path);
        Excel::store(new allExport('dec15m.physique', ['datas' => $data]), $path, 'appsfile');

        $message = str_replace("{MONTH}", $month, $params->message_physique);


        $tos = explode("|", $params->mails_to);
        $ccs = explode("|", $params->mails_cc);

        $bcc = ['andre-marie.akuete@orabank.net'];


        Helper::sendMail($fileName, $message, $path, $tos, $ccs, $bcc,'appsfile');

        return 'done';
    }

    /**
     * géneration fichier centif personne morale
     *
     * @return void
     */
    public  function genMoral()
    {

        ini_set("memory_limit", -1);
        set_time_limit(-1);

        $data = SELF::morale();

        $monthNumber = Carbon::now()->format('m');
        $monthNumber = $monthNumber - 1;
        $month = Helper::mois($monthNumber);

        $params = SELF::getParams();
        // $fileName = "15MILLIONS_PERSONNE_MORALE_" . $month;
        $fileName = str_replace("{MONTH}", $month, $params->filename_moral);

        // $path = '15M/' . $fileName . '.xlsx';

        $path = str_replace("{YEAR}", Helper::getYearDec(), $params->path);
        $path = str_replace("{FILENAME}", $fileName, $path);
        $path = str_replace("{MONTH}", $month, $path);

        // Export and save the file to the specified path
        Excel::store(new allExport('dec15m.morale', ['datas' => $data]), $path, 'appsfile');

        $message = str_replace("{MONTH}", $month, $params->message_morale);


        $tos = explode("|", $params->mails_to);
        $ccs = explode("|", $params->mails_cc);

        $bcc = ['andre-marie.akuete@orabank.net'];

        Helper::sendMail($fileName, $message, $path, $tos, $ccs, $bcc,'appsfile');

        return 'done';
    }

    public static function load()
    {
        ini_set("memory_limit", -1);
        set_time_limit(-1);

        $ret = SELF::getReq();
        return $ret;
    }


    public static function getReq()
    {
        //BKHEVE_CENTIFD
        Log::info("BKHEVE_CENTIFD BEGIN");
        Schema::connection('dbedi')->dropIfExists('BKHEVE_CENTIFD');

        DB::connection('dbedi')->statement(
            "CREATE TABLE BKHEVE_CENTIFD AS
            SELECT E.*
            FROM BKHEVE E
            WHERE E.NAT IN ('VERESP', 'RETESP', 'AGERET', 'AGEVER')
            AND E.ETA NOT IN ('AB', 'IF', 'IG', 'AN', 'AT')
            AND E.DCO BETWEEN TO_DATE('01'||TO_CHAR(ADD_MONTHS(ORA_GETDATECOMP(ora_getsitecent), -1), '/MM/YYYY'), 'DD/MM/YYYY')
            AND LAST_DAY(TO_DATE('01'||TO_CHAR(ADD_MONTHS(ORA_GETDATECOMP(ora_getsitecent), -1), '/MM/YYYY'), 'DD/MM/YYYY'))

            "
        );
        Log::info("BKHEVE_CENTIFD DONE");

        //BKHIEVE_CENTIFD
        Log::info("BKHIEVE_CENTIFD BEGIN");

        Schema::connection('dbedi')->dropIfExists('BKHIEVE_CENTIFD');

        DB::connection('dbedi')->statement(
            "CREATE TABLE BKHIEVE_CENTIFD AS
            SELECT I.*
            FROM BKHIEVE I
            WHERE (I.DATEH||I.AGE||I.OPE||I.EVE) IN (
                SELECT (E.DATEH||E.AGE||E.OPE||E.EVE)
                FROM BKHEVE_CENTIFD E
            )
            AND I.IDEN IN ('CFNMP', 'CFPRP')

            "
        );


        DB::connection('dbedi')->statement("UPDATE BKHIEVE_CENTIFD I SET I.VALA = TRIM(UPPER(ora_cleanText(I.VALA)))");

        Log::info("BKHIEVE_CENTIFD DONE");
        //SPORABJCENTIFD
        Log::info("SPORABJCENTIFD BEGIN");
        Schema::connection('dbedi')->dropIfExists('SPORABJCENTIFD');
        DB::connection('dbedi')->statement(
            "CREATE TABLE SPORABJCENTIFD AS
                SELECT E.DATEH, E.OPE, E.EVE, E.TYP, E.NDOS, E.AGSA, E.NAT, ora_gettypcli(E.CLI1) TCLI, E.AGE1 AGE, E.DEV1 DEV, E.NCP1 NCP, E.CLC1 CLC, E.CLI1 CLI, E.NOM1 NOM, E.GES1 GES, E.SEN1 SEN, E.MHT1 MHT, E.MON1 MON, E.DVA1 DVA, E.SOL1 SOL, E.CAI2 CAI, E.DCAI2 DCAI, E.MNAT, E.DOU, E.DCO, E.ETA, E.UTI, E.UTF, E.UTA, E.LIB2, E.LIB8, E.LIB9, E.NATP, E.NUMP, E.DATP, E.NOMP, E.AD1P, E.AD2P, E.DELP, E.NCHE, E.DSAI, E.HSAI, E.PAYSP, E.PDELP
                FROM BKHEVE_CENTIFD E
                WHERE (
                    E.NAT = 'RETESP'
                    AND TRIM(E.CLI1) NOT IN (
                        SELECT TRIM(N.LIB2)
                        FROM BKNOM N
                        WHERE N.CTAB = '323'
                    )
                )

                UNION

                SELECT E.DATEH, E.OPE, E.EVE, E.TYP, E.NDOS, E.AGSA, E.NAT, ora_gettypcli(E.CLI2) TCLI, E.AGE2 AGE, E.DEV2 DEV, E.NCP2 NCP, E.CLC2 CLC, E.CLI2 CLI, E.NOM2 NOM, E.GES2 GES, E.SEN2 SEN, E.MHT2 MHT, E.MON2 MON, E.DVA2 DVA, E.SOL2 SOL, E.CAI1 CAI, E.DCAI1 DCAI, E.MNAT, E.DOU, E.DCO, E.ETA, E.UTI, E.UTF, E.UTA, E.LIB2, E.LIB8, E.LIB9, E.NATP, E.NUMP, E.DATP, E.NOMP, E.AD1P, E.AD2P, E.DELP, E.NCHE, E.DSAI, E.HSAI, E.PAYSP, E.PDELP
                FROM BKHEVE_CENTIFD E
                WHERE (
                    E.NAT = 'VERESP'
                    AND TRIM(E.CLI2) NOT IN (
                        SELECT TRIM(N.LIB2)
                        FROM BKNOM N
                        WHERE N.CTAB = '323'
                    )
                )

            "
        );
        Log::info("SPORABJCENTIFD DONE");
        //SPORABJCENTIF
        Log::info("SPORABJCENTIF BEGIN");
        Schema::connection('dbedi')->dropIfExists('SPORABJCENTIF');
        DB::connection('dbedi')->statement(
            "CREATE TABLE SPORABJCENTIF AS
                SELECT T.NAT, T.CLI, T.DCO, SUM(T.MHT) CUM_MON
                FROM SPORABJCENTIFD T
                GROUP BY T.NAT, T.CLI, T.DCO
                HAVING SUM(T.MHT) >= (
                    SELECT N.MNT1
                    FROM BKNOM N
                    WHERE N.CTAB = '098'
                    AND CACC='DEC-CENTIF'
                )
                ORDER BY T.DCO, T.NAT, T.CLI

            "
        );
        DB::connection('dbedi')->statement(
            "DELETE FROM SPORABJCENTIFD D
                WHERE (D.NAT||D.CLI||D.DCO) NOT IN (
                    SELECT (T.NAT||T.CLI||T.DCO)
                    FROM SPORABJCENTIF T
                )
            "
        );

        DB::connection('dbedi')->statement(
            "SELECT D.*
                FROM SPORABJCENTIFD D
                WHERE (D.NAT||D.CLI||D.DCO) NOT IN (
                    SELECT (T.NAT||T.CLI||T.DCO)
                    FROM SPORABJCENTIF T
                )
            "
        );

        DB::connection('dbedi')->statement(
            "UPDATE SPORABJCENTIFD D
                SET D.LIB8 = (
                    SELECT I.VALA
                    FROM BKHIEVE_CENTIFD I
                    WHERE I.IDEN = 'CFNMP'
                    AND (I.DATEH||I.AGE||I.OPE||I.EVE) = (D.DATEH||D.AGE||D.OPE||D.EVE)
                ),
                D.LIB9 = (
                    SELECT I.VALA
                    FROM BKHIEVE_CENTIFD I
                    WHERE I.IDEN = 'CFPRP'
                    AND (I.DATEH||I.AGE||I.OPE||I.EVE) = (D.DATEH||D.AGE||D.OPE||D.EVE)
                )
                WHERE D.LIB8 IN ('HP', 'SP')
            "
        );

        DB::connection('dbedi')->statement(
            "UPDATE SPORABJCENTIFD D
                SET D.LIB8 = (
                    SELECT I.VALA
                    FROM BKHIEVE_CENTIFD I
                    WHERE I.IDEN = 'CFNMP'
                    AND (I.DATEH||I.AGE||I.OPE||TRIM(I.EVE)) = (
                        SELECT (E.DATEH||E.AGE||E.OPE||TRIM(E.EVE))
                        FROM BKHEVE_CENTIFD E
                        WHERE (E.DATEH||E.AGE||E.OPE||TRIM(E.NDOS)) = (D.DATEH||D.AGE||D.OPE||TRIM(D.EVE))
                        AND E.NAT = 'AGERET'
                    )
                ),
                D.LIB9 = (
                    SELECT I.VALA
                    FROM BKHIEVE_CENTIFD I
                    WHERE I.IDEN = 'CFPRP'
                    AND (I.DATEH||I.AGE||I.OPE||TRIM(I.EVE)) = (
                        SELECT (E.DATEH||E.AGE||E.OPE||TRIM(E.EVE))
                        FROM BKHEVE_CENTIFD E
                        WHERE (E.DATEH||E.AGE||E.OPE||TRIM(E.NDOS)) = (D.DATEH||D.AGE||D.OPE||TRIM(D.EVE))
                        AND E.NAT = 'AGERET'
                    )
                )
                WHERE D.LIB8 IS NULL
                AND D.NAT = 'RETESP'
            "
        );

        DB::connection('dbedi')->statement(
            "UPDATE SPORABJCENTIFD D
                SET D.LIB8 = (
                    SELECT I.VALA
                    FROM BKHIEVE_CENTIFD I
                    WHERE I.IDEN = 'CFNMP'
                    AND (I.DATEH||I.AGE||I.OPE||TRIM(I.EVE)) = (
                        SELECT Max(E.DATEH||E.AGE||E.OPE||TRIM(E.EVE))
                        FROM BKHEVE_CENTIFD E
                        WHERE (E.DATEH||E.AGE||E.OPE||TRIM(E.NDOS)) = (D.DATEH||D.AGE||D.OPE||TRIM(D.EVE))
                        AND E.NAT = 'AGEVER'
                    )
                ),
                D.LIB9 = (
                    SELECT I.VALA
                    FROM BKHIEVE_CENTIFD I
                    WHERE I.IDEN = 'CFPRP'
                    AND (I.DATEH||I.AGE||I.OPE||TRIM(I.EVE)) = (
                        SELECT Max(E.DATEH||E.AGE||E.OPE||TRIM(E.EVE))
                        FROM BKHEVE_CENTIFD E
                        WHERE (E.DATEH||E.AGE||E.OPE||TRIM(E.NDOS)) = (D.DATEH||D.AGE||D.OPE||TRIM(D.EVE))
                        AND E.NAT = 'AGEVER'
                    )
                )
                WHERE D.LIB8 IS NULL
                AND D.NAT = 'VERESP'
            "
        );

        DB::connection('dbedi')->statement(
            "UPDATE SPORABJCENTIFD D
            SET D.NOM = TRIM(UPPER(ora_cleanText(D.NOM))),
            D.LIB2 = TRIM(UPPER(ora_cleanText(D.LIB2))),
            D.LIB8 = TRIM(UPPER(ora_cleanText(D.LIB8))),
            D.LIB9 = TRIM(UPPER(ora_cleanText(D.LIB9))),
            D.NOMP = TRIM(UPPER(ora_cleanText(D.NOMP))),
            D.AD1P = TRIM(UPPER(ora_cleanText(D.AD1P))),
            D.AD2P = TRIM(UPPER(ora_cleanText(D.AD2P))),
            D.DELP = TRIM(UPPER(ora_cleanText(D.DELP))),
            D.PDELP = TRIM(UPPER(ora_cleanText(D.PDELP)))
            "
        );

        Log::info("SPORABJCENTIF DONE");

        return 'DONE';
    }


    public static function physique()
    {
        #	ETAT DES OPERATIONS DE DEPOT-RETRAIT PERSONNE PHYSIQUE SUPERIEUR A 15M
        $data = DB::connection('dbedi')->select(
            "SELECT
                TRIM(ora_getlibnom('001', D.AGE))  AGENCE,
                TO_CHAR(D.DCO, 'DD/MM/YYYY')  DATE_COMPTABLE,
                TRIM(D.CLI)  CODE_CLIENT,
                TRIM(ora_getnomclinom(D.CLI))  NOM_CLIENT,
                TRIM(ora_getnomclipre(D.CLI))  PRENOM_CLIENT,
                TRIM(ora_getidextcli(D.CLI)) IFU,
                TRIM(ora_getadcli(D.CLI, 'D'))  ADDRESSE_CLIENT,
                UPPER(ORA_GETLIBNOM('071', ora_getseccli(D.CLI)))  SECTEUR_CLIENT,
                UPPER(TRIM(ora_getlibnom('188', ora_getsegcli(D.CLI))))  SEGMENT_CLIENT,
                TRIM(D.NCP)||'-'||TRIM(D.CLC)   COMPTE_RAPPROCHEMENT,
                DECODE(D.NAT, 'RETESP', 'RETRAIT ESPECE', 'VERESP', 'VERSEMENT ESPECE', 'NAT')  TYPE_OPERATION,
                D.MHT  MONTANT,
                TRIM(D.LIB8) NOM_PORTEUR,
                TRIM(D.LIB9) PRENOMS_PORTEUR,
                REGEXP_REPLACE(TRIM(D.NOMP), '( ){2,}', ' ') NOM_PRENOMS_REMETTANT,
                DECODE(REGEXP_REPLACE(TRIM(TRIM((
                    CASE
                    WHEN (D.NATP = '00013') THEN 'CIP'
                    WHEN (D.NATP = '00014') THEN 'CNIB'
                    WHEN (D.NATP = '00015') THEN 'NIP'
                    WHEN (D.NATP = '00008') THEN 'CIM'
                    WHEN (D.NATP = '00009') THEN 'PERMIS'
                    WHEN (D.NATP = '00097') THEN 'ATT. ID.'
                    WHEN (D.NATP = '00011') THEN 'CRES'
                    WHEN (D.NATP = '00012') THEN 'AUTRE'
                    WHEN (D.NATP = '00010') THEN 'REC CNI'
                    WHEN (D.NATP = '00003') THEN 'CP'
                    WHEN (D.NATP = '00006') THEN 'ACT. NAIS.'
                    WHEN (D.NATP = '00007') THEN 'CCONS.'
                    WHEN (D.NATP = '00004') THEN 'CRFJ'
                    WHEN (D.NATP = '00001') THEN 'CNI'
                    WHEN (D.NATP = '00002') THEN 'PASS'
                    WHEN (D.NATP = '00005') THEN 'CSEJ'
                    ELSE (SELECT TRIM(N.LIB1) FROM BKNOM N WHERE N.CTAB = '078' AND N.CACC = D.NATP)
                    END
                ))||DECODE(REGEXP_REPLACE(REGEXP_REPLACE(D.NUMP, '( ){2,}', ' '), '(-){2,}', '-'), NULL, ' ', '  ', ' ', '-', ' ', '-', ' ', CONCAT(' N° ', TRIM(D.NUMP)))
                ||DECODE(D.DATP, NULL, ' ', CONCAT(' DELIVRE LE ', TRIM(D.DATP)))
                ||DECODE(D.DELP, NULL, ' ', CONCAT(' A ', TRIM(D.DELP)))),
                '( ){2,}', ' '), 'N°', ' ', REGEXP_REPLACE(TRIM(TRIM((
                    CASE
                    WHEN (D.NATP = '00013') THEN 'CIP'
                    WHEN (D.NATP = '00014') THEN 'CNIB'
                    WHEN (D.NATP = '00015') THEN 'NIP'
                    WHEN (D.NATP = '00008') THEN 'CIM'
                    WHEN (D.NATP = '00009') THEN 'PERMIS'
                    WHEN (D.NATP = '00097') THEN 'ATT. ID.'
                    WHEN (D.NATP = '00011') THEN 'CRES'
                    WHEN (D.NATP = '00012') THEN 'AUTRE'
                    WHEN (D.NATP = '00010') THEN 'REC CNI'
                    WHEN (D.NATP = '00003') THEN 'CP'
                    WHEN (D.NATP = '00006') THEN 'ACT. NAIS.'
                    WHEN (D.NATP = '00007') THEN 'CCONS.'
                    WHEN (D.NATP = '00004') THEN 'CRFJ'
                    WHEN (D.NATP = '00001') THEN 'CNI'
                    WHEN (D.NATP = '00002') THEN 'PASS'
                    WHEN (D.NATP = '00005') THEN 'CSEJ'
                    ELSE (SELECT TRIM(N.LIB1) FROM BKNOM N WHERE N.CTAB = '078' AND N.CACC = D.NATP)
                    END
                ))||DECODE(REGEXP_REPLACE(REGEXP_REPLACE(D.NUMP, '( ){2,}', ' '), '(-){2,}', '-'), NULL, ' ', '  ', ' ', '-', ' ', '-', ' ', CONCAT(' N° ', TRIM(D.NUMP)))
                ||DECODE(D.DATP, NULL, ' ', CONCAT(' DELIVRE LE ', TRIM(D.DATP)))
                ||DECODE(D.DELP, NULL, ' ', CONCAT(' A ', TRIM(D.DELP)))),
                '( ){2,}', ' ')) PIECE_IDENTITE_REMETTANT,
                (TRIM(D.UTI)||(SELECT '-'||TRIM(U.LIB) FROM EVUTI U WHERE U.CUTI = D.UTI)) SAISIE_PAR
                FROM SPORABJCENTIFD D
                WHERE D.TCLI =  '1'
                AND D.DCO BETWEEN TO_DATE('01'||TO_CHAR(ADD_MONTHS(ORA_GETDATECOMP(ora_getsitecent), -1), '/MM/YYYY'), 'DD/MM/YYYY')
                AND LAST_DAY(TO_DATE('01'||TO_CHAR(ADD_MONTHS(ORA_GETDATECOMP(ora_getsitecent), -1), '/MM/YYYY'), 'DD/MM/YYYY'))

                ORDER BY D.DCO, D.CLI ASC

            "
        );

        return $data;
    }

    public function morale()
    {
        #		ETAT DES OPERATIONS DE DEPOT-RETRAIT PERSONNE MORALE SUPERIEUR A 15M
        $data = DB::connection('dbedi')->select(
            "SELECT
                TRIM(ora_getlibnom('001', D.AGE))  AGENCE,
                TO_CHAR(D.DCO, 'DD/MM/YYYY')  DATE_COMPTABLE,
                TRIM(D.CLI)  CODE_CLIENT,
                TRIM(ora_getnomclinom(D.CLI))  NOM_CLIENT,
                TRIM(ora_getrsocli(D.CLI)) RAISON_CLIENT,
                TRIM(ora_getsigcli(D.CLI)) SIGLE_CLIENT,
                TRIM(ora_getnidfcli(D.CLI)) IFU,
                TRIM(ora_getidextcli(D.CLI)) IMMATRICULATION_EXTERNE,
                TRIM(ora_getadcli(D.CLI, 'D'))  ADDRESSE_CLIENT,
                UPPER(ORA_GETLIBNOM('071', ora_getseccli(D.CLI)))  SECTEUR_CLIENT,
                UPPER(TRIM(ora_getlibnom('188', ora_getsegcli(D.CLI)))) SEGMENT_CLIENT,
                TRIM(D.NCP)||'-'||TRIM(D.CLC)   COMPTE_RAPPROCHEMENT,
                DECODE(D.NAT, 'RETESP', 'RETRAIT ESPECE', 'VERESP', 'VERSEMENT ESPECE', 'NAT')  TYPE_OPERATION,
                D.MHT  MONTANT,
                TRIM(D.LIB8) NOM_PORTEUR,
                TRIM(D.LIB9) PRENOMS_PORTEUR,
                REGEXP_REPLACE(TRIM(D.NOMP), '( ){2,}', ' ') NOM_PRENOMS_REMETTANT,
                DECODE(REGEXP_REPLACE(TRIM(TRIM((
                    CASE
                    WHEN (D.NATP = '00013') THEN 'CIP'
                    WHEN (D.NATP = '00014') THEN 'CNIB'
                    WHEN (D.NATP = '00015') THEN 'NIP'
                    WHEN (D.NATP = '00008') THEN 'CIM'
                    WHEN (D.NATP = '00009') THEN 'PERMIS'
                    WHEN (D.NATP = '00097') THEN 'ATT. ID.'
                    WHEN (D.NATP = '00011') THEN 'CRES'
                    WHEN (D.NATP = '00012') THEN 'AUTRE'
                    WHEN (D.NATP = '00010') THEN 'REC CNI'
                    WHEN (D.NATP = '00003') THEN 'CP'
                    WHEN (D.NATP = '00006') THEN 'ACT. NAIS.'
                    WHEN (D.NATP = '00007') THEN 'CCONS.'
                    WHEN (D.NATP = '00004') THEN 'CRFJ'
                    WHEN (D.NATP = '00001') THEN 'CNI'
                    WHEN (D.NATP = '00002') THEN 'PASS'
                    WHEN (D.NATP = '00005') THEN 'CSEJ'
                    ELSE (SELECT TRIM(N.LIB1) FROM BKNOM N WHERE N.CTAB = '078' AND N.CACC = D.NATP)
                    END
                ))||DECODE(REGEXP_REPLACE(REGEXP_REPLACE(D.NUMP, '( ){2,}', ' '), '(-){2,}', '-'), NULL, ' ', '  ', ' ', '-', ' ', '-', ' ', CONCAT(' N° ', TRIM(D.NUMP)))
                ||DECODE(D.DATP, NULL, ' ', CONCAT(' DELIVRE LE ', TRIM(D.DATP)))
                ||DECODE(D.DELP, NULL, ' ', CONCAT(' A ', TRIM(D.DELP)))),
                '( ){2,}', ' '), 'N°', ' ', REGEXP_REPLACE(TRIM(TRIM((
                    CASE
                    WHEN (D.NATP = '00013') THEN 'CIP'
                    WHEN (D.NATP = '00014') THEN 'CNIB'
                    WHEN (D.NATP = '00015') THEN 'NIP'
                    WHEN (D.NATP = '00008') THEN 'CIM'
                    WHEN (D.NATP = '00009') THEN 'PERMIS'
                    WHEN (D.NATP = '00097') THEN 'ATT. ID.'
                    WHEN (D.NATP = '00011') THEN 'CRES'
                    WHEN (D.NATP = '00012') THEN 'AUTRE'
                    WHEN (D.NATP = '00010') THEN 'REC CNI'
                    WHEN (D.NATP = '00003') THEN 'CP'
                    WHEN (D.NATP = '00006') THEN 'ACT. NAIS.'
                    WHEN (D.NATP = '00007') THEN 'CCONS.'
                    WHEN (D.NATP = '00004') THEN 'CRFJ'
                    WHEN (D.NATP = '00001') THEN 'CNI'
                    WHEN (D.NATP = '00002') THEN 'PASS'
                    WHEN (D.NATP = '00005') THEN 'CSEJ'
                    ELSE (SELECT TRIM(N.LIB1) FROM BKNOM N WHERE N.CTAB = '078' AND N.CACC = D.NATP)
                    END
                ))||DECODE(REGEXP_REPLACE(REGEXP_REPLACE(D.NUMP, '( ){2,}', ' '), '(-){2,}', '-'), NULL, ' ', '  ', ' ', '-', ' ', '-', ' ', CONCAT(' N° ', TRIM(D.NUMP)))
                ||DECODE(D.DATP, NULL, ' ', CONCAT(' DELIVRE LE ', TRIM(D.DATP)))
                ||DECODE(D.DELP, NULL, ' ', CONCAT(' A ', TRIM(D.DELP)))),
                '( ){2,}', ' ')) PIECE_IDENTITE_REMETTANT,
                (TRIM(D.UTI)||(SELECT '-'||TRIM(U.LIB) FROM EVUTI U WHERE U.CUTI = D.UTI)) SAISIE_PAR
                FROM SPORABJCENTIFD D
                WHERE D.TCLI <> '1'

                AND D.DCO BETWEEN TO_DATE('01'||TO_CHAR(ADD_MONTHS(ORA_GETDATECOMP(ora_getsitecent), -1), '/MM/YYYY'), 'DD/MM/YYYY') AND LAST_DAY(TO_DATE('01'||TO_CHAR(ADD_MONTHS(ORA_GETDATECOMP(ora_getsitecent), -1), '/MM/YYYY'), 'DD/MM/YYYY'))
                ORDER BY D.DCO, D.CLI ASC

            "
        );

        return $data;
    }



    public static function notify($subject, $tos, $ccs, $bccs, $view, $data = [])
    {

        $from = [env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME')];

        $tos[] = ['email' => 'salime.salikou@orabank.net', "name" => "Andre-MArie AKUETE"];

        // $ccs[] =  ['email' => $initiateur->employeInfo->email, "name" => Utilisateurs::getHNomPrenom($initiateur)];

        if (sizeof($tos) > 0) {
            try {
                $mail = Mail::send("mail.dec15m", $data, function ($message) use ($tos, $ccs, $bccs, $subject, $from) {
                    $message->from($from[0], $from[1]);
                    $message->subject($subject);

                    foreach ($tos as $to) $message->to($to['email'], $to['name']);
                    // foreach ($ccs as $cc) $message->cc($cc['email'], $cc['name']);
                    // foreach ($bccs as $bcc) $message->bcc($bcc['email'], $bcc['name']);
                });

                return $mail;
            } catch (\Exception $e) {
                Log::info($e->getMessage());
            }
        }
    }

    public function envoi_mail()
    {


        $mail             = new PHPMailer();
        $mail->From       = "objalerte@orabank.net";
        $mail->FromName   = 'ORABANK';
        $mail->IsSMTP();
        $mail->Host       = "smtp.orabank.group";
        $mail->Port       = 25;
        $mail->SMTPAuth   = false;
        $mail->Username   = 'oranet.benin@orabank.net';
        $mail->Password   = null;


        $mail->clearAttachments();
        $mail->ClearAllRecipients();
        $mail->clearCCs();
        $mail->clearCustomHeaders();


        $message = "TEST";

        $mail->Subject = 'MAIL TEST';


        $mail->Body       =   $message;

        $email_principale = "andre-marie.akuete@orabank.net";
        $mail->AddAddress(trim($email_principale));


        $mail->IsHTML(true);
        $mail->WordWrap = 50;
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';

        $copie = "salime.salikou@orabank.net";

        //envoi des mails vers les destinataires
        if (!$mail->Send()) {
            return  "NOT SEND";
        } else {

            return  "SEND";
        }
    }

    public static function getParams()
    {
        return Dec15mParams::first();
    }
}
