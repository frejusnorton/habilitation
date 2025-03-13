<table>
    <thead>
        <tr>
            <td>FILIALE</td>
            <td>DATE_REFERENCE</td>
            <td>CODE_CLIENT</td>
            <td>CHAPITRE</td>
            <td>REFERENCE</td>
            <td>NUM_COMPTE_ENGAGEMENT</td>
            <td>NOM_ET_PRENOMS</td>
            <td>TYPE_DE_CREDIT</td>
            <td>MONTANT_INITIAL_CREDIT</td>
            <td>ENCOURS_CREDIT</td>
            <td>IMPAYE</td>
            <td>DATE_MISE_EN_PLACE</td>
            <td>DATE_PREMIERE_ECHEANCE</td>
            <td>DATE_DERNIERE_ECHEANCE</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($datas as $item)
            <tr>
                <td>{{ $item->FILIALE }}</td>
                <td>{{ $item->DATE_REFERENCE }}</td>
                <td>{{ $item->CODE_CLIENT }}</td>
                <td>{{ $item->CHAPITRE }}</td>
                <td>{{ $item->REFERENCE }}</td>
                <td>{{ $item->NUM_COMPTE_ENGAGEMENT }}</td>
                <td>{{ $item->NOM_ET_PRENOMS }}</td>
                <td>{{ $item->TYPE_DE_CREDIT }}</td>
                <td>{{ $item->MONTANT_INITIAL_CREDIT }}</td>
                <td>{{ $item->ENCOURS_CREDIT }}</td>
                <td>{{ $item->IMPAYE }}</td>
                <td>{{ $item->DATE_MISE_EN_PLACE }}</td>
                <td>{{ $item->DATE_PREMIERE_ECHEANCE }}</td>
                <td>{{ $item->DATE_DERNIERE_ECHEANCE }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
