<table>
    <thead>
        <tr>
            <td>FILIALE</td>
            <td>DATE_REFERENCE</td>
            <td>CODE_CLIENT</td>
            <td>NUM_COMPTE_COURANT</td>
            <td>NOM_ET_PRENOM</td>
            <td>CUMUL_MVT_CREDIT</td>
            <td>AGIOS</td>
            <td>DUREE</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($datas as $item)
            <tr>
                <td>{{ $item->FILIALE }}</td>
                <td>{{ $item->DATE_REFERENCE }}</td>
                <td>{{ $item->CODE_CLIENT }}</td>
                <td>{{ $item->NUM_COMPTE_COURANT }}</td>
                <td>{{ $item->NOM_ET_PRENOM }}</td>
                <td>{{ $item->CUMUL_MVT_CREDIT }}</td>
                <td>{{ $item->AGIOS }}</td>
                <td>{{ $item->DUREE }}</td>
            </tr>
        @endforeach
    </tbody>
</table>