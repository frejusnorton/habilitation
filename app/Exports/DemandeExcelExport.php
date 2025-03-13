<?php

namespace App\Exports;

use App\Models\Demande;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DemandeExcelExport implements FromCollection, WithHeadings
{
    /**
     * Récupérer les utilisateurs à exporter.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Demande::with('user')->get()->map(function ($demande) {
            return [
                'Référence' => $demande->reference,
                'Date de la demande' => $demande->created_at->format('d/m/Y'), 
                'Utilisateur' => $demande->user ? $demande->user->nom . ' ' . $demande->user->prenom : 'Non défini',
              'Statut' => $this->getStatutText($demande->statut),
            ];
        });
    }

    private function getStatutText($statut)
    {
        switch ($statut) {
            case 0:
                return 'En attente de validation';
            case 1:
                return 'En attente d\'approbation';
            case 2:
                return 'Validée';
            case 3:
                return 'Rejetée';
            default:
                return 'Inconnu';
        }
    }

    /**
     * Ajouter les en-têtes de colonnes dans le fichier Excel.
     */
    public function headings(): array
    {
        return [
            'Référence',
            'Date de la demande',
            'Utilisateur',
            'Statut',
        ];
    }
    
}
