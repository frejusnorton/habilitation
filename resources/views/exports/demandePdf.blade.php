<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Demandes</title>
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
    <h2 style="text-align: center;">Liste des demandes</h2>
    <table>
        <thead>
            <tr>
                <th>Référence</th>
                <th>Date de la demande</th>
                <th>Utilisateur</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($demandes as $demande)
            <tr>
                <td>{{ $demande->reference }}</td>
                <td>{{$demande->created_at->format('d/m/Y')}}</td>
                <td>{{ $demande->user ? $demande->user->nom . ' ' . $demande->user->prenom : 'Non défini'}}</td>
                <td>
                    @if ($demande->statut == 0)
                    En attente de validation
                    @elseif ($demande->statut == 1)
                    En attente d'approbation
                    @elseif ($demande->statut == 2)
                    Validée
                    @elseif ($demande->statut == 3)
                    Rejetée
                    @else
                    Inconnu
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>