<table>
    <thead>
        <tr>
            <td>AGE</td>
            <td>DEV</td>
            <td>CHA</td>
            <td>CLI</td>
            <td>NCP</td>
            <td>NOMS_CLIENT</td>
            <td>SDE</td>
            <td>SDECV</td>
            <td>SDMOY</td>
            <td>SDMOYCV</td>
            <td>ATT1</td>
            <td>PAYS_DE_RESIDENCE</td>
            <td>ATT2</td>
            <td>AGENT_ECONOMIQUE</td>
            <td>ATT7</td>
            <td>SECTEUR_ACTIVITE</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($datas as $item)
            <tr>
                <td>{{ $item->age }}</td>
                <td>{{ $item->dev }}</td>
                <td>{{ $item->cha }}</td>
                <td>{{ $item->cli }}</td>
                <td>{{ $item->ncp }}</td>
                <td>{{ $item->NOMS_CLIENT }}</td>
                <td>{{ $item->sde }}</td>
                <td>{{ $item->sdecv }}</td>
                <td>{{ $item->sdmoy }}</td>
                <td>{{ $item->sdmoycv }}</td>
                <td>{{ $item->att1 }}</td>
                <td>{{ $item->Pays_de_residence }}</td>
                <td>{{ $item->att2 }}</td>
                <td>{{ $item->Agent_economique }}</td>
                <td>{{ $item->att7 }}</td>
                <td>{{ $item->Secteur_activite }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
