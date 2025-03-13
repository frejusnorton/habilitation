<?php

namespace App\Http\Controllers;

use App\Exports\allExport;
use App\Helpers\SimpleXLSX;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use PDO;
use PDOException;

class WhbController extends Controller
{
    public function searchAcc()
    {
        // Date => 0
        // Numero => 1
        // Montant => 2
        // reference => 2

        ini_set("memory_limit", -1);
        set_time_limit(-1);

        // $acc= DB::connection('whb')->select("SELECT * FROM journal LIMIT 1");
        // dd($acc);
        $xls = new SimpleXLSX(public_path("/WHB/wb.xlsx"));
        $content = $xls->rows();

        $accList = [];
        foreach ($content as $key => $value) {

            if ($key == 0) continue;


            $acc = DB::connection('whb')->select("SELECT search_acc(?,?,?) as ncp", [
                substr($value[0], 0, 10),
                $value[2],
                $value[1]
            ]);

            if (isset($acc[0])) {
                Log::info($acc[0]->ncp);

                $res = DB::connection('dbedi')->SELECT("SELECT age,ncp,inti FROM BKCOM where ncp = :ncp ", [
                    'ncp' => $acc[0]->ncp
                ]);

                if ($res && isset($res[0])) {

                    $list = [
                        'date' => substr($value[0], 0, 10),
                        'reference' => $value[3],
                        'numero' => $value[1],
                        'age' => $res[0]->age,
                        'ncp' => $res[0]->ncp,
                        'inti' => $res[0]->inti,
                        'montant' => $value[2],
                    ];

                    $accList[] = $list;
                }
            }
        }

        $fileName = 'WHB' . Carbon::now()->format('d_m_Y') . '_' . Carbon::now()->timestamp;
        return Excel::download(new allExport('whb.data', ['datas' => $accList]), $fileName . '.xlsx');
    }
}
