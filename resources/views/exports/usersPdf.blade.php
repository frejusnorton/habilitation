<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des utilisateurs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h2 style="text-align: center;">Liste des utilisateurs</h2>
    <table>
        <thead>
            <tr>
                <th>Noms & Prénoms</th>
                <th>Rôle</th>
                <th>Poste</th>
                <th>Agence</th>
                <th>Direction</th>
                <th>Hiérarchie</th>
                <th>Statut</th>
                <th>Date de création</th>
                <th>Val 1</th>
                <th>Val 2</th>
                <th>Val 3</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->nom }} {{ $user->prenom }} </td>
                <td>{{ $user->userRole->role_name ?? 'Non défini' }}</td>
                <td>{{ $user->poste ?? 'Non défini' }}</td>
                <td>{{ $user->agence->lib ?? 'Non défini' }}</td>
                <td>{{ $user->direction->libelle ?? 'Non défini' }}</td>
                <td>{{ $user->superieur ? $user->superieur->nom . ' ' . $user->superieur->prenom : 'Non renseigné' }}</td>
                <td>{{ $user->statut == 1 ? 'Actif' : 'Inactif' }}</td>
                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                <td>{{ $user->validateur1->nom ?? 'Non défini' }}</td>
                <td>{{ $user->validateur2->nom ?? 'Non défini' }}</td>
                <td>{{ $user->validateur3->nom ?? 'Non défini' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
