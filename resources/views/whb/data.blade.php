<table>
    <tr>
        <td>date</td>
        <td>reference</td>
        <td>age</td>
        <td>ncp</td>
        <td>inti</td>
        <td>montant</td>
    </tr>
    <tbody>
        @foreach ($datas as $item)
            <tr>
                <td>{{ $item['date'] }}</td>
                <td>{{ $item['reference'] }}</td>
                <td>{{ $item['age'] }}</td>
                <td>{{ $item['ncp'] }}</td>
                <td>{{ $item['inti'] }}</td>
                <td>{{ $item['montant'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>


