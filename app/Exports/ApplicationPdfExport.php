<?php
namespace App\Exports;


use App\Models\Application;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ApplicationPdfExport implements FromView
{
    /**
     * Récupérer les utilisateurs à exporter.
     *
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        return view('exports.applicationPdf', [
            'applications' => Application::all()
        ]);
    }
    
}
