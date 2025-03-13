<!DOCTYPE html>
<html>

<head>
    <style>
        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 80%;
        }

        #customers td,
        #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #e25d99;
            color: white;
        }
    </style>
</head>

<body>

    <h1>{{ __('Liste des menus') }}</h1>

    <table id="customers">
        <tr class="">
            <th class="">{{ __('Role') }}</th>
            <th class="">{{ __('Menu') }}</th>
        </tr>
        <tr>
            @forelse ($menus as $item)
        <tr>
            <td class="">
                {{ $item['role_id'] }}
            </td>
            <td class="">
                {{ $item['menu_id'] }}
            </td>
        </tr>
    @empty
        @endforelse
        </tr>

    </table>

</body>

</html>

