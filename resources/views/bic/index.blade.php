<table>
    @foreach ($datas as $item)
        <tr>
            @foreach ($item as $value)
                <td>{{ strval($value) }}</td>
            @endforeach
        </tr>
    @endforeach
</table>
