<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Agence;
use App\Models\Demande;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\UsersExcelExport;
use App\Exports\AgenceExcelExport;
use App\Exports\DemandeExcelExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ApplicationExcelExport;
use App\Models\Application;

class ExportController extends Controller
{
    
    //USERS
    public function exportUsersExcel()
    {
        return Excel::download(new UsersExcelExport, 'users.xlsx');
    }
    public function exportUsersPdf()
    {
        $pdf = Pdf::loadView('exports.usersPdf', [
            'users' => User::all()
        ])->setPaper('a4', 'landscape');;
        
        return $pdf->download('users.pdf');
    }

      //DEMANDES
    public function exportDemandeExcel()
    {
        return Excel::download(new DemandeExcelExport, 'demande.xlsx');
    }

    public function exportDemandePdf()
    {
        $pdf = Pdf::loadView('exports.demandePdf', [
            'demandes' => Demande::all()
        ]);
        
        return $pdf->download('demandes.pdf');
    }

        //AGENCES
        public function exportAgenceExcel()
        {
            return Excel::download(new AgenceExcelExport, 'agences.xlsx');
        }
    
        public function exportAgencePdf()
        {
            $pdf = Pdf::loadView('exports.agencePdf', [
                'agences' => Agence::all()
            ]);
            
            return $pdf->download('agences.pdf');
        }
    
    //APPLICATIONS
    public function exportApplicationExcel()
    {
        return Excel::download(new ApplicationExcelExport, 'application.xlsx');
    }

    public function exportApplicationPdf()
    {
        $pdf = Pdf::loadView('exports.applicationPdf', [
            'applications' => Application::all()
        ]);
        
        return $pdf->download('application.pdf');
    }


}

