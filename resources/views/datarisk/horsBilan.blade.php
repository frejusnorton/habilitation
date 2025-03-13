<table>
    <thead>
        <tr>
            <td>FILIALE</td>
            <td>DATE_DE_REFERENCE</td>
            <td>CHAPITRE</td>
            <td>DEVISE</td>
            <td>CODE_CLIENT</td>
            <td>COMPTE</td>
            <td>CLIENT</td>
            <td>INTITULE_COMPTE</td>
            <td>CODE_OPERATION</td>
            <td>SOLDE_DU_COMPTE</td>
            <td>DATE_PASSAGE_EN_DEBIT</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($datas as $item)
            <tr>
                <td>{{ $item->filiale }}</td>
                <td>{{ $item->date_de_reference }}</td>
                <td>{{ $item->chapitre }}</td>
                <td>{{ $item->devise }}</td>
                <td>{{ $item->code_client }}</td>
                <td>{{ $item->compte }}</td>
                <td>{{ $item->client }}</td>
                <td>{{ $item->intitule_compte }}</td>
                <td>{{ $item->code_operation }}</td>
                <td>{{ $item->solde_du_compte }}</td>
                <td>{{ $item->date_passage_en_debit }}</td>

            </tr>
        @endforeach
    </tbody>
</table>
