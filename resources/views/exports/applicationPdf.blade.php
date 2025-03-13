<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des applications</title>
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
    <h2 style="text-align: center;">Liste des applications</h2>
    <table>
        <thead>
            <tr>
                <th>Libelle</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($applications as $application)
            <tr>
                <td>{{ $application->libelle }}</td>
                <td>{{ $application->statut === '1' ? 'Active' :'Inactif'}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
