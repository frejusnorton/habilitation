<div class="mt-10">
    <h4>Listes des profils </h4>
</div>

<div class="table-responsive">
    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
        <thead>
            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                <th class="min-w-125px">Libelle</th>
                <th class="min-w-125px text-center">Statut</th>
                <th class="min-w-100px">Action</th>
            </tr>
        </thead>

        <tbody class="text-gray-600 fw-semibold">
            @forelse ($profils as $profil)
            <tr>
                <td>
                    <div class="text-gray-800 text-hover-primary mb-1">{{ $profil->libelle }}</div>
                </td>
                <td class="text-center">
                    {!! $profil->statut == 0
                    ? '<div class="badge badge-light-danger fw-bold">Inactif</div>'
                    : '<div class="badge badge-light-success fw-bold">Active</div>' !!}
                </td>
                <td class="d-flex gap-5">
                    <i class="bi bi-pencil text-warning" style="cursor: pointer;" data-bs-toggle="modal"
                        data-bs-target="#kt_modal_edit_apk" data-libelle="{{$profil->libelle}}" id="edit_apk"
                        data-id="{{$profil->id}}"
                        data-url="{{ route('application_role.update', ['application_role' => $profil->id]) }}">
                    </i>

                    <i class="bi bi-trash text-danger" style="cursor: pointer;"></i>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Aucune donnée</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    {{-- {{ $apkRoles->links('pagination.custom') }} --}}
</div>

</div>