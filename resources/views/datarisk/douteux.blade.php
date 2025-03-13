<table>
    <thead>
        <tr>
            <td>FILIALE</td>
            <td>DATE_DE_REFERENCE</td>
            <td>CODE_CLIENT</td>
            <td>NUM_COMPTE_DOUTEUX</td>
            <td>NOM_ET_PRENOMS</td>
            <td>DATE_DECLASSEMENT</td>
            <td>MONTANT_ENGAGEMENT</td>
            <td>MONTANT_DOUTEUX</td>
            <td>MONTANT_DES_PROVISIONS</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($datas as $item)
            <tr>
                <td>{{ $item->filiale }}</td>
                <td>{{ $item->date_de_reference }}</td>
                <td>{{ $item->code_client }}</td>
                <td>{{ $item->num_compte_douteux }}</td>
                <td>{{ $item->nom_et_prenoms }}</td>
                <td>{{ $item->date_declassement }}</td>
                <td>{{ $item->montant_engagement }}</td>
                <td>{{ $item->montant_douteux }}</td>
                <td>{{ $item->montant_des_provisions }}</td>

            </tr>
        @endforeach
    </tbody>
</table>
