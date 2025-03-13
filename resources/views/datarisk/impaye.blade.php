<table>
    <thead>
        <tr>
            <td>filiale</td>
            <td>date_reference</td>
            <td>code_client</td>
            <td>chapitre</td>
            <td>reference</td>
            <td>compte_impaye</td>
            <td>nom_et_prenom</td>
            <td>montant_impaye</td>
            <td>date_premier_impaye</td>
            <td>encours</td>
            <td>credit_immobilier</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($datas as $item)
            <tr>
                <td>{{ $item->filiale }}</td>
                <td>{{ $item->date_reference }}</td>
                <td>{{ $item->code_client }}</td>
                <td>{{ $item->chapitre }}</td>
                <td>{{ $item->reference }}</td>
                <td>{{ $item->compte_impaye }}</td>
                <td>{{ $item->nom_et_prenom }}</td>
                <td>{{ $item->montant_impaye }}</td>
                <td>{{ $item->date_premier_impaye }}</td>
                <td>{{ $item->encours }}</td>
                <td>{{ $item->credit_immobilier }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
