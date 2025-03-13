<?php
namespace App\Exports;


use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UsersPdfExport implements FromView
{
    /**
     * Récupérer les utilisateurs à exporter.
     *
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        return view('exports.usersPdf', [
            'users' => User::all()
        ]);
    }
    
}
