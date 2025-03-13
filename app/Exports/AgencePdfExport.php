<?php
namespace App\Exports;

use App\Models\Agence;
use App\Models\Demande;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AgencePdfExport implements FromView
{
    /**
     * Récupérer les utilisateurs à exporter.
     *
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        return view('exports.agencePdf', [
            'agences' => Agence::all()
        ]);
    }
    
}
