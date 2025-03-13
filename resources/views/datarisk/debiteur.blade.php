<table>
    <thead>
        <tr>
            <td>filiale</td>
            <td>DATE_DE_REFERENCE</td>
            <td>CHAPITRE</td>
            <td>CODE_CLIENT</td>
            <td>Num_COMPTE_COURANT</td>
            <td>NOM_ET_PRENOMS</td>
            <td>DATE_DERNIER_MVT_CREDIT</td>
            <td>DATE_DEBITEUR</td>
            <td>SOLDE_COMPTE</td>
            <td>MONTANT_AUTORISATION</td>
            <td>DATE_ECHEANCE_AUTORISATION</td>
            <td>DEPASSEMENT</td>
            <td>DATE_DEPASSEMENT</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($datas as $item)
            <tr>
                <td>{{ $item->filiale }}</td>
                <td>{{ $item->DATE_DE_REFERENCE }}</td>
                <td>{{ $item->CHAPITRE }}</td>
                <td>{{ $item->CODE_CLIENT }}</td>
                <td>{{ $item->Num_COMPTE_COURANT }}</td>
                <td>{{ $item->NOM_ET_PRENOMS }}</td>
                <td>{{ $item->DATE_DERNIER_MVT_CREDIT }}</td>
                <td>{{ $item->DATE_DEBITEUR }}</td>
                <td>{{ $item->SOLDE_COMPTE }}</td>
                <td>{{ $item->MONTANT_AUTORISATION }}</td>
                <td>{{ $item->DATE_ECHEANCE_AUTORISATION }}</td>
                <td>{{ $item->DEPASSEMENT }}</td>
                <td>{{ $item->DATE_DEPASSEMENT }}</td>
            </tr>
        @endforeach
    </tbody>
</table>