<?php

namespace App\Exports;

use App\Models\Agence;
use App\Models\Application;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ApplicationExcelExport implements FromCollection, WithHeadings
{
    /**
     * Récupérer les utilisateurs à exporter.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Application::all()->map(function ($application) {
            return [
                'Application' => $application->libelle,
                'Statut' => $application->statut === 1 ? 'Inactive' : 'Active',
            ];
        });
    }
    /**
     * Ajouter les en-têtes de colonnes dans le fichier Excel.
     */
    public function headings(): array
    {
        return [
            'Application',
            'Statut',
        ];
    }
}
