<table>
    <thead>
        <tr>
            <td>FILIALE</td>
            <td>DATE_DE_REFERENCE</td>
            <td>CODE_CLIENT</td>
            <td>NUMERO_COMPTE_GARANTIE</td>
            <td>NOM_ET_PRENOMS</td>
            <td>CODE_NATURE_GARANTIE</td>
            <td>LIBELLE_NATURE_GARANTIE</td>
            <td>MONTANT_GARANTIE</td>
            <td>DATE_INSCRIPTION</td>
            <td>DATE_ECHEANCE</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($datas as $item)
            <tr>
                <td>{{ $item->filiale }}</td>
                <td>{{ $item->date_de_reference }}</td>
                <td>{{ $item->code_client }}</td>
                <td>{{ $item->numero_compte_garantie }}</td>
                <td>{{ $item->nom_et_prenoms }}</td>
                <td>{{ $item->code_nature_garantie }}</td>
                <td>{{ $item->libelle_nature_garantie }}</td>
                <td>{{ $item->montant_garantie }}</td>
                <td>{{ $item->date_inscription }}</td>
                <td>{{ $item->date_echeance }}</td>

            </tr>
        @endforeach
    </tbody>
</table>
