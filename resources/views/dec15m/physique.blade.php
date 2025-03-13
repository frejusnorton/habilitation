<table>
    <thead>
        <tr>
            <td>agence</td>
            <td>date_comptable</td>
            <td>code_client</td>
            <td>nom_client</td>
            <td>prenom_client</td>
            <td>ifu</td>
            <td>addresse_client</td>
            <td>secteur_client</td>
            <td>segment_client</td>
            <td>compte_rapprochement</td>
            <td>type_operation</td>
            <td>montant</td>
            <td>nom_porteur</td>
            <td>prenoms_porteur</td>
            <td>nom_prenoms_remettant</td>
            <td>piece_identite_remettant</td>
            <td>saisie_par</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($datas as $item)
            <tr>
                <td>{{ $item->agence }}</td>
                <td>{{ $item->date_comptable }}</td>
                <td>{{ $item->code_client }}</td>
                <td>{{ $item->nom_client }}</td>
                <td>{{ $item->prenom_client }}</td>
                <td>{{ $item->ifu }}</td>
                <td>{{ $item->addresse_client }}</td>
                <td>{{ $item->secteur_client }}</td>
                <td>{{ $item->segment_client }}</td>
                <td>{{ $item->compte_rapprochement }}</td>
                <td>{{ $item->type_operation }}</td>
                <td>{{ $item->montant }}</td>
                <td>{{ $item->nom_porteur }}</td>
                <td>{{ $item->prenoms_porteur }}</td>
                <td>{{ $item->nom_prenoms_remettant }}</td>
                <td>{{ $item->piece_identite_remettant }}</td>
                <td>{{ $item->saisie_par }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
