<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class Dec15MController extends Controller {

    public function index()  {
        $ret = SELF::getReq();
        dd($ret);
    }


    public function getReq()  {
        DB::selectRaw("DROP TABLE BKHEVE_CENTIFD;
                        CREATE TABLE BKHEVE_CENTIFD AS
                        SELECT E.*
                        FROM BKHEVE E
                        WHERE E.NAT IN ('VERESP', 'RETESP', 'AGERET', 'AGEVER')
                        AND E.ETA NOT IN ('AB', 'IF', 'IG', 'AN', 'AT')
                        AND E.DCO BETWEEN TO_DATE('01'||TO_CHAR(ADD_MONTHS(ORA_GETDATECOMP(ora_getsitecent), -1), '/MM/YYYY'), 'DD/MM/YYYY') AND LAST_DAY(TO_DATE('01'||TO_CHAR(ADD_MONTHS(ORA_GETDATECOMP(ora_getsitecent), -1), '/MM/YYYY'), 'DD/MM/YYYY'));
        ");
        return 'done';
    }

}
