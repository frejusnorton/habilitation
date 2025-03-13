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
    <h2 style="text-align: center;">Liste des agences</h2>
    <table>
        <thead>
            <tr>
                <th>Code Agence</th>
                <th>Libelle</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($agences as $agence)
            <tr>
                <td>{{  $agence->age }} </td>
                <td>{{  $agence->lib }}</td>
                
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
