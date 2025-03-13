<table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
    <thead>
        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

            <th class="min-w-125px">Role</th>
            <th class="min-w-125px">Menu </th>
        </tr>
    </thead>
    <tbody class="text-gray-600 fw-semibold">
        @forelse ($rolemenus as $rolemenu)
            <tr>
                <td class="d-flex align-items-center">
                    <div class="d-flex flex-column ">
                        <a href="view.html"
                            class="text-gray-800 text-hover-primary mb-1">{{ $rolemenu->role->role_name ? $rolemenu->role->role_name : '' }}</a>
                    </div>
                </td>
                <td>
                    <div class="badge badge-light fw-bold">{{ $rolemenu->menu->titre ? $rolemenu->menu->titre : '' }}</div>
                </td>


            </tr>

        @empty
        @endforelse



    </tbody>
</table>
