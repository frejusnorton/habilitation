<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExcelExport implements FromCollection, WithHeadings
{
    /**
     * Récupérer les utilisateurs à exporter.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::all()->map(function ($user) {
            return [
                'ID' => $user->id,
                'Nom' => $user->nom,
                'Prénom' => $user->prenom,
                'Rôle' => $user->userRole->role_name ?? 'Non défini', 
                'Poste' => $user->poste ?? 'Non défini',
                'Agence' => $user->agence->lib ?? 'Non défini', // Si relation agence
                'Direction' => $user->direction->libelle ?? 'Non défini',
                'Service' => $user->service->libelle ?? 'Non défini',
                'Département' => $user->departement->libelle ?? 'Non défini',
              'Supérieur hiérarchique' => optional($user->superieur)->nom . ' ' . optional($user->superieur)->prenom ?? 'Aucun',
                'Statut' => $user->statut == 1 ? 'Actif' : 'Inactif',
                'Type de connexion' => $user->auth_type == 'LOCAL' ? 'LOCAL' : 'LDAP',
                'Date de création' => $user->created_at->format('d/m/Y'),
                'Validateur 1' => optional($user->validateur1)->nom ?? 'Non défini',
                'Validateur 2' => optional($user->validateur2)->nom ?? 'Non défini',
                'Validateur 3' => optional($user->validateur3)->nom . '' . optional($user->validateur3)->prenom ?? 'Non défini',
            ];
        });
    }
    
    

    /**
     * Ajouter les en-têtes de colonnes dans le fichier Excel.
     *
     * @return array
     */public function headings(): array
{
    return [
        'ID', 
        'Nom', 
        'Prénom', 
        'Rôle', 
        'Poste', 
        'Agence', 
        'Direction', 
        'Service', 
        'Département', 
        'Supérieur hiérarchique', 
        'Statut', 
        'Type de connexion', 
        'Date de création', 
        'Validateur 1', 
        'Validateur 2', 
        'Validateur 3'
    ];
}
}
