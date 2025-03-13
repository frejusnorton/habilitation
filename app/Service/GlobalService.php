<?php

namespace App\Service;

use App\Exports\AllExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class GlobalService
{

    // $name: le nom du fichier; $lien: le chemin du fichier;
    //$datas: mes données a affichées; $namevariable: mes données a affiché sur la vue
    public function getExcel($name, $lien, $datas, $namevariable)
    {
        $filename = $name . '_' . date('d-m-Y H:i:s');
        return Excel::download(
            new AllExport($lien, [$namevariable => $datas]),
            $filename . '.xlsx'
        );
    }

    public function getPdf($name, $lien, $datas, $namevariable)
    {
        $filename = $name . '_' . date('d-m-Y H:i:s');
        $pdf = Pdf::loadView($lien, [$namevariable => $datas]);
        return $pdf->download($filename . ".pdf");
    }
}
