<table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
    <thead>
        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

            <th class="min-w-125px">Titre</th>
            <th class="min-w-125px">Identifiant</th>
            <th class="min-w-125px">Menu</th>
            <th class="min-w-125px">Statut</th>
        </tr>
    </thead>
    <tbody class="text-gray-600 fw-semibold">
        @forelse ($actions as $action)
            <tr>
                <td class="d-flex align-items-center">
                    <div class="d-flex flex-column ">
                        <a href="view.html"
                            class="text-gray-800 text-hover-primary mb-1">{{ $action->libelle ? $action->libelle : '' }}</a>
                    </div>
                </td>
                <td>
                    <div class="badge badge-light fw-bold">{{ $action->identifiant ? $action->identifiant : '' }}</div></td>
                <td class="">
                    <div class="badge badge-light fw-bold">{{ $action->menu->titre ? $action->menu->titre : '' }}</div>
                </td>
                <td class="">
                    {!! $action->statut == 0
                        ? '<div class="badge badge-light-danger fw-bold">Non active</div>'
                        : '<div class="badge badge-light-success fw-bold">Active</div>' !!}
                </td>

            </tr>

        @empty
        @endforelse



    </tbody>
</table>
