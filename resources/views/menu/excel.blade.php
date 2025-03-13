<table class="" id="">
    <thead>
        <tr class="">

            <th class="min-w-125px">Titre</th>
            <th class="min-w-125px">Titre secondaire</th>
            <th class="min-w-125px">Nom de la route </th>
            <th class="min-w-125px text-center">Icone</th>
            <th class="min-w-125px text-center">Statut</th>
            <th class="min-w-125px text-center">Sous menu</th>
        </tr>
    </thead>
    <tbody class="">
        @forelse ($menus as $menu)
            <tr>
                <td class="d-flex align-items-center">

                    {{ $menu->titre ? $menu->titre : '' }}


                </td>
                <td>
                    {{ $menu->titresecondaire ? $menu->titresecondaire : '' }}
                </td>
                <td>
                    {{ $menu->routename ? $menu->routename : '#' }}
                </td>
                <td class="text-center">
                    {{ $menu->icone ? $menu->icone : '' }}
                </td>
                <td class="text-center">
                    {!! $menu->statut == 0 ? 'Non active' : 'Active' !!}
                </td>
                <td class="text-center">
                    {!! $menu->issubmenu == true ? 'Sous menu' : 'Menu' !!}
                </td>

            </tr>

        @empty
            <tr>
                <td colspan="6" class="text-center">Aucune donnée</td>
            </tr>
        @endforelse



    </tbody>
</table>
