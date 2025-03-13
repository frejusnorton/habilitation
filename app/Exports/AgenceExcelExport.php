<?php

namespace App\Exports;

use App\Models\Agence;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AgenceExcelExport implements FromCollection, WithHeadings
{
    /**
     * Récupérer les utilisateurs à exporter.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Agence::all()->map(function ($agence) {
            return [
                'Code Agence' => $agence->age,
                'Libelle' => $agence->lib,
            ];
        });
    }

    /**
     * Ajouter les en-têtes de colonnes dans le fichier Excel.
     */
    public function headings(): array
    {
        return [
            'Code Agence',
            'Libelle',
        ];
    }
}
