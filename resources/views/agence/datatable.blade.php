<!--begin::Table-->
<div class="table-responsive mx-4">
    <table class="table align-middle table-row-dashed fs-6 gy-5 " id="kt_table_users">
        <thead>
            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                <th class="min-w-125px">Code</th> 
                <th class="min-w-125px text-end">Libelle</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 fw-semibold">
            @forelse ($agences as $agence)
                <tr>
                    <td>
                        <div class="text-gray-800 text-hover-primary mb-1">{{ $agence->age }}</div>
                    </td>
                    <td class="text-end">
                        <div class="text-gray-800 text-hover-primary mb-1">{{ $agence->lib }}</div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Aucune donnée</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $agences->links('pagination.custom') }}
</div>
